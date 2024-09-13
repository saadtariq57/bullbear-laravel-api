<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\User;
use App\Models\GroupCategory;
use App\Models\GroupMembers;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GroupController extends Controller
{

    public function groupsPage()
    {
        return view('groups.group');
    }


    public function index(Request $request)
    {
        $search = $request->query('search');

        if ($search) {
            $groups = Group::with('category')
                        ->withCount('members')
                        ->where(function ($query) use ($search) {
                            $query->where('group_name', 'LIKE', "%{$search}%")
                                    ->orWhere('symbol', 'LIKE', "%{$search}%")
                                    ->orWhere('group_title', 'LIKE', "%{$search}%")
                                    ->orWhereHas('category', function ($query) use ($search) {
                                        $query->where('name', 'LIKE', "%{$search}%");
                                    });
                        })
                        ->paginate(15);
        } else {
            $groups = Group::with('category')
                        ->withCount('members')
                        ->paginate(15);
        }
        
        if ($request->route()->named('admin.groups.*')) {
            return view('admin.groups.index', compact('groups'));
        } else {
            return response()->json($groups);
        }
    }

    public function siteGroupSearch(Request $request)
    {
        $search = $request->input('query');

        if ($search) {
            $groups = Group::select(['id', 'group_name', 'group_title', 'avatar'])
                                ->where('group_name', 'LIKE', "%{$search}%")
                                ->orWhere('group_title', 'LIKE', "%{$search}%")
                                ->orWhere('group_name', 'LIKE', "%{$search}%")
                                ->orderByRaw("CASE WHEN group_name LIKE '{$search}%' THEN 1 ELSE 2 END, group_name")
                                ->limit(10)
                                ->get();
        } else {
            $groups = [];
        }

        return response()->json($groups);
    }


    public function showMembers($groupId)
    {
        $group = Group::with(['members' => function($query) {
                    $query->select('users.id', 'users.name', 'users.email')
                          ->withPivot('role', 'active', 'last_seen');
                }])
                ->withCount('members')
                ->find($groupId);

        if (!$group) {
            return response()->json(['message' => 'Group not found'], 404);
        }
        
        return view('admin.groups.members', ['members' => $group->members, 'group' => $group, 'membersCount' => $group->members_count]);
    }


    public function updateMember(Request $request, Group $group)
    {
        $userId = $request->user_id;
        $role = $request->role;
        $status = $request->status;

        // Specify the table name in the where clause to avoid ambiguity
        $member = $group->members()->where('group_members.user_id', $userId)->first();

        if ($member) {
            // Update pivot table details
            $member->pivot->role = $role;
            $member->pivot->status = $status;
            $member->pivot->updated_at = now();
            $member->pivot->save();
            return response()->json(['message' => 'Member updated successfully.']);
        } else {
            // If the member is not already part of the group, add them
            $group->members()->attach($userId, ['role' => $role, 'active' => $active, 'created_at' => now(), 'updated_at' => now() ]);
            return response()->json(['message' => 'New member added successfully.']);
        }
    }



    public function removeMember(Request $request, Group $group)
    {
        $userId = $request->user_id;
        $group->members()->detach($userId);
        return response()->json(['message' => 'Member removed successfully.']);
    }

    public function joinGroup(Request $request, $groupId)
    {
        $user = $request->user();
        $group = Group::findOrFail($groupId);

        $member = $group->members()->where('group_members.user_id', $user->id)->first();

        if ($group->join_privacy == 'public') {
            if (!$member) {
                $group->members()->attach($user->id, ['status' => 'active']);
                return response()->json(['joined' => true, 'requestPending' => false, 'message' => 'You have joined the group.']);
            }
        } elseif ($group->join_privacy == 'private') {
            if (!$member) {
                $group->members()->attach($user->id, ['status' => 'pending']);
                return response()->json(['joined' => false, 'requestPending' => true, 'message' => 'Your request to join the group has been sent.']);
            }
        }

        return response()->json(['error' => true, 'message' => 'Unable to process join request.'], 400);
    }


    public function joinedChats(Request $request)
{
    $userName = $request->query('userName');

    if ($userName) {
        $user = User::where('name', $userName)->first();
    } else {
        $user = $request->user();
    }
    $currentUser = $request->user();
    // return response()->json($user);
    if (!$user) {
        return response()->json(['error' => 'User not found'], 404);
    }

    $joinedGroups = Group::whereHas('members', function($query) use ($user) {
        $query->where('group_members.user_id', $user->id)
              ->whereIn('group_members.status', ['active', 'pending', 'rejected']);
    })
    ->withCount('members')
    ->with(['members' => function($query) use ($user) {
        $query->where('group_members.user_id', $user->id)
              ->select(['group_members.user_id', 'group_members.status', 'group_members.updated_at', 'group_members.role']);
    }])
    ->get();

    return response()->json($joinedGroups->map(function($group) {
        $member = $group->members->first();
        if ($member) {
            $group->joined = $member->status === 'active';
            $group->requestPending = $member->status === 'pending';
        } else {
            $group->joined = false;
            $group->requestPending = false;
        }
        $group->membersCount = $group->members_count;
        return $group;
    }));
}


    public function suggestedChats(Request $request)
    {
        $userId = $request->user()->id ?? null;

        $query = Group::query();

        if ($userId) {
            // If user is logged in, fetch groups they're not a member of
            $query->whereDoesntHave('members', function($q) use ($userId) {
                $q->where('group_members.user_id', $userId);
            })
            ->with(['members' => function($q) use ($userId) {
                $q->where('group_members.user_id', $userId);
            }]);
        }

        $recentlyActiveGroups = $query->whereHas('messages', function($q) {
                $q->orderBy('created_at', 'desc');
            })
            ->withCount('members')
            ->withCount('messages')
            ->orderBy('messages_count', 'desc')
            ->take(10)
            ->get();

        return response()->json($recentlyActiveGroups->map(function($group) use ($userId) {
            if ($userId) {
                $member = $group->members->first();
                $group->joined = $member && $member->pivot->status === 'active';
                $group->requestPending = $member && $member->pivot->status === 'pending';
            } else {
                $group->joined = false;
                $group->requestPending = false;
            }
            return $group;
        }));
    }

    public function create()
    {
        $categories = GroupCategory::all();
        return view('admin.groups.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $user = $request->user();

        $validatedData = $request->validate([
            'group_name' => 'required|string|max:255',
            'group_title' => 'required|string|max:255',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'cover' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'about' => 'nullable|string',
            'category_id' => 'required|exists:group_categories,id',
            'privacy' => 'required|string|in:public,private',
            'join_privacy' => 'required|boolean',
            'active' => 'required|boolean',
            'symbol' => 'nullable|string|max:255',
            'exchange' => 'nullable|string|max:255'
        ]);

        if ($request->hasFile('avatar')) {
            $validatedData['avatar'] = $request->file('avatar')->store(
                "photos/" . now()->year . "/" . now()->month, 'public'
            );
        }

        if ($request->hasFile('cover')) {
            $validatedData['cover'] = $request->file('cover')->store(
                "photos/" . now()->year . "/" . now()->month, 'public'
            );
        }

        $validatedData['user_id'] = $user->id;
        $validatedData['time'] = time();
        Group::create($validatedData);

        return redirect()->route('admin.groups.index')->with('success', 'Group created successfully');
    }


    public function edit(Group $group)
    {
        return view('admin.groups.edit', compact('group'));
    }

    public function update(Request $request, Group $group)
    {
        $validatedData = $request->validate([
            'group_name' => 'required|string|max:255',
            'group_title' => 'required|string|max:255',
            'about' => 'nullable|string',
            'category_id' => 'required|exists:group_categories,id',
            'privacy' => 'required|string|in:public,private',
            'join_privacy' => 'required|in:public,private',
            'active' => 'required|boolean',
            'symbol' => 'nullable|string|max:255',
            'exchange' => 'nullable|string|max:255'
        ]);

        if ($request->hasFile('avatar')) {
            $validatedData['avatar'] = $request->file('avatar')->store(
                "photos/" . now()->year . "/" . now()->month, 'public'
            );
        } else {
            $validatedData['avatar'] = $group->avatar;
        }

        if ($request->hasFile('cover')) {
            $validatedData['cover'] = $request->file('cover')->store(
                "photos/" . now()->year . "/" . now()->month, 'public'
            );
        } else {
            $validatedData['cover'] = $group->cover;
        }
        $validatedData['time'] = time();
        $group->update($validatedData);
        return response()->json(['message' => 'Group updated successfully']);
    }



    public function destroy(Group $group)
    {
        $group->delete();
        return redirect()->route('admin.groups.index')->with('success', 'Group deleted successfully');
    }


    public function categoriesIndex(Request $request)
    {
        $search = $request->query('search');
        if ($search) {
            $categories = GroupCategory::where('name', 'LIKE', "%{$search}%")
                ->paginate(10);
        } else {
            $categories = GroupCategory::paginate(10);
        }

        return view('admin.groups.categories.index', compact('categories'));
    }


    /**
     * Show the form for creating a new group category.
     */
    public function categoriesCreate()
    {
        return view('admin.groups.categories.create');
    }

    public function categoriesStore(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'about' => 'string|max:255',
            // other validation rules
        ]);
        
        GroupCategory::create($validatedData);
        return redirect()->route('admin.groups.categories.index')->with('success', 'Category created successfully');
    }

    public function categoriesEdit(GroupCategory $category)
    {
        return view('admin.groups.categories.edit', compact('category'));
    }

    public function categoriesUpdate(Request $request, GroupCategory $category)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'about' => 'string|max:255',
        ]);
        
        $category->update($validatedData);
        return redirect()->route('admin.groups.categories.index')->with('success', 'Category updated successfully');
    }

    public function categoriesDestroy(GroupCategory $category)
    {
        $category->delete();
        return redirect()->route('admin.groups.categories.index')->with('success', 'Category deleted successfully');
    }

    public function getGroupById($id)
    {
        $group = Group::withCount('members') // This counts the members relationship
                   ->find($id);

        if (!$group) {
            return response()->json(['message' => 'Group not found'], 404);
        }

        return response()->json($group);
    }
    public function groupCoverPosition(Request $request){
        $group_id = $request->input('group_id');
        $group = Group::find($group_id);
    // Check if group exists
    if (!$group) {
        return response()->json(['message' => 'Group not found'], 404);
    }

    // Update the 'cover_position' from the request
    $group->cover_position = $request->input('cover_position');
    $group->save(); // Save the changes

    // Return a success response
    return response()->json(['message' => 'Cover position updated successfully'], 200);
    }
    public function updateGroupCover(Request $request){
        $request->validate([
            'cover_photo' => 'required|image|mimes:jpeg,png,jpg|max:2048', // Validate the incoming input
        ]);
    
        $group = Group::find($request->group_id);
        if (!$group) {
            return response()->json(['message' => 'Group not found'], 404);
        }
    
        // Handle the file upload
        if ($request->hasFile('cover_photo')) {
            $file = $request->file('cover_photo')->store('/photos', 'public');
            
    
            // Update the group cover image path and cover position
            // $group->update(['cover' => $file]);
            $group->cover = $file;
            $group->cover_position = '0px';
            $group->save();
    
            return response()->json(['message' => 'Cover updated successfully', 'path' => $file]);
        }
    
        return response()->json(['message' => 'Invalid file provided'], 400);
    }
    public function removeGroupCoverPhoto(Request $request) {
        $group = Group::find($request->input('group_id'));
        if (!$group) {
            return response()->json(['message' => 'Group not found'], 404);
        }

        // Assuming the fields in your database are `cover` and `cover_position`
        $group->cover = 'photos/d-cover.jpg';
        $group->cover_position = '0px';
        $group->save();

        return response()->json(['message' => 'Cover removed successfully', 'group' => $group]);
    }
    public function GroupProfilePhoto(Request $request){
        $request->validate([
            'profile_photo' => 'required|image|mimes:jpeg,png,jpg|max:2048', // Validate the incoming input
        ]);
    
        $group = Group::find($request->group_id);
        if (!$group) {
            return response()->json(['message' => 'Group not found'], 404);
        }
    
        // Handle the file upload
        if ($request->hasFile('profile_photo')) {
            $file = $request->file('profile_photo')->store('/photos', 'public');
            
    
            // Update the group cover image path and cover position
            $group->update(['avatar' => $file]);
    
            return response()->json(['message' => 'Cover updated successfully', 'path' => $file]);
        }
    
        return response()->json(['message' => 'Invalid file provided'], 400);
    }
    public function getGroupMembers($groupId)
    {
        $group = Group::with(['members' => function($query) {
            $query->select('users.id', 'users.name', 'users.avatar'); // Customize the fields as needed
        }])
        ->withCount('members')
        ->find($groupId);

        if (!$group) {
            return response()->json(['message' => 'Group not found'], 404);
        }

        // return response()->json($group->members);
        $response = [
            'members' => $group->members,
            'members_count' => $group->members_count
        ];
    
        return response()->json($response);
    }
    public function updateGroupMember(Request $request, $groupId)
    {

        $userId = $request->user_id;
        $role = $request->role;
        $status = $request->status;

        // First, find the group to ensure it exists
        $group = Group::find($groupId);
        if (!$group) {
            return response()->json(['message' => 'Group not found'], 404);
        }

        // Check if the user is a member of the group
        $member = $group->members()->where('users.id', $userId)->first();
        if (!$member) {
            return response()->json(['message' => 'Member not found in the group'], 404);
        }

        // Update role and status in the pivot table
        $group->members()->updateExistingPivot($userId, [
            'role' => $role,
            'status' => $status,
            // 'updated_at' => now();
        ]);

        // Optionally, you can reload the group with its members to reflect the change
        $group->load('members');

        // Return the updated group data
        return response()->json([
            'message' => 'Member updated successfully',
            'group' => $group
        ]);
    }
    
    public function removeGroupMember(Request $request, $groupId)
    {
        $memberId = $request->member_id;

        // First, find the group
        $group = Group::find($groupId);
        if (!$group) {
            return response()->json(['message' => 'Group not found'], 404);
        }
    
        // Check if the user is a member of the group
        $isMember = $group->members()->where('users.id', $memberId)->exists();
        if (!$isMember) {
            return response()->json(['message' => 'Member not found in the group'], 404);
        }
    
        // Remove the member from the group
        $group->members()->detach($memberId);
    
        // Optionally, reload the group with its members
        $group->load('members');
    
        // Return the updated group data
        return response()->json(['message' => 'Cover updated successfully']);
    }

    public function checkUserGroupRole(Request $request, $groupId)
    {
        $memberId = $request->member_id;
        $actingUserId = auth()->id();
        $group = Group::find($groupId);
        if (!$group) {
            return response()->json(['message' => 'Group not found'], 404);
        }

        // Check if the acting user is an admin of the group
        $actingMember = $group->members()->where('users.id', $actingUserId)->first();
        if (!$actingMember || $actingMember->pivot->role === 'admin') {
            return response()->json(['authorized' => true]);
        } else {
            return response()->json(['authorized' => false]);
        }
    }


    public function defaultGroups()
    {
        // Fetch default groups from the database or any other source
        $defaultGroups = Group::orderBy('created_at', 'desc')->take(30)->get(); // Example: Fetching 10 latest groups
        return response()->json($defaultGroups);
    }
}