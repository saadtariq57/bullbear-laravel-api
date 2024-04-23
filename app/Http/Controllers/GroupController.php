<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\GroupCategory;
use App\Models\GroupMembers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class GroupController extends Controller
{

    public function groupsPage()
    {
        return view('groups.group');
    }

    public function joinedChats(Request $request)
    {
        $user = $request->user();
        $joinedGroups = Group::whereHas('members', function($query) use ($user) {
            $query->where('group_members.user_id', $user->id);
        })->get();

        return response()->json($joinedGroups);
    }

    public function suggestedChats(Request $request)
    {
        $recentlyActiveGroups = Group::whereHas('messages', function($query) {
            $query->orderBy('created_at', 'desc');
        })->take(10)->get();

        return response()->json($recentlyActiveGroups);
    }

    public function index(Request $request)
    {
        $search = $request->query('search');


        if($search) {
            $groups = Group::with('category')
                            ->where(function ($query) use ($search) {
                                $query->where('group_name', 'LIKE', "%{$search}%")
                                      ->orWhere('symbol', 'LIKE', "%{$search}%")
                                      ->orWhereHas('category', function ($query) use ($search) {
                                          $query->where('name', 'LIKE', "%{$search}%");
                                      });
                            })
                            ->paginate(15);
        } else {
            $groups = Group::with('category')->paginate(15);
        }

        return view('admin.groups.index', compact('groups'));
    }


    public function showMembers($groupId)
    {
        $group = Group::with(['members' => function($query) {
            $query->select('users.id', 'users.name', 'users.email')
                  ->withPivot('role', 'active', 'last_seen');
        }])->find($groupId);

        if (!$group) {
            Log::info('Group not found for ID: ' . $groupId);
            return response()->json(['message' => 'Group not found'], 404);
        }

        Log::info('Members data:', ['members' => $group->members->toArray()]);
        return view('admin.groups.members', ['members' => $group->members, 'group' => $group]);
    }

    /*public function updateMember(Request $request, Group $group)
    {
        $userId = $request->user_id;
        $role = $request->role;
        $active = $request->active;

        $group->members()->updateOrCreate(
            ['user_id' => $userId],
            ['role' => $role, 'active' => $active]
        );

        return response()->json(['message' => 'Member updated successfully.']);
    }*/


    public function updateMember(Request $request, Group $group)
    {
        $userId = $request->user_id;
        $role = $request->role;
        $active = $request->active;

        // Specify the table name in the where clause to avoid ambiguity
        $member = $group->members()->where('group_members.user_id', $userId)->first();

        if ($member) {
            // Update pivot table details
            $member->pivot->role = $role;
            $member->pivot->active = $active;
            $member->pivot->save();
            return response()->json(['message' => 'Member updated successfully.']);
        } else {
            // If the member is not already part of the group, add them
            $group->members()->attach($userId, ['role' => $role, 'active' => $active]);
            return response()->json(['message' => 'New member added successfully.']);
        }
    }



    public function removeMember(Request $request, Group $group)
    {
        $userId = $request->user_id;
        $group->members()->detach($userId);

        return response()->json(['message' => 'Member removed successfully.']);
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
                "upload/photos/" . now()->year . "/" . now()->month, 'public'
            );
        }

        if ($request->hasFile('cover')) {
            $validatedData['cover'] = $request->file('cover')->store(
                "upload/photos/" . now()->year . "/" . now()->month, 'public'
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
            'join_privacy' => 'required|boolean',
            'active' => 'required|boolean',
            'symbol' => 'nullable|string|max:255',
            'exchange' => 'nullable|string|max:255'
        ]);

        if ($request->hasFile('avatar')) {
            $validatedData['avatar'] = $request->file('avatar')->store(
                "upload/photos/" . now()->year . "/" . now()->month, 'public'
            );
        } else {
            $validatedData['avatar'] = $group->avatar;
        }

        if ($request->hasFile('cover')) {
            $validatedData['cover'] = $request->file('cover')->store(
                "upload/photos/" . now()->year . "/" . now()->month, 'public'
            );
        } else {
            $validatedData['cover'] = $group->cover;
        }
        $validatedData['time'] = time();
        $group->update($validatedData);

        return redirect()->route('admin.groups.index')->with('success', 'Group updated successfully');
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
}