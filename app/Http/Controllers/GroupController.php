<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\GroupCategory;
use App\Models\GroupMembers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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

    public function showMembers(Group $group)
    {
        $members = $group->members()
                         ->with('user')
                         ->get(['user_id', 'role', 'active', 'last_seen']);

        return view('admin.groups.members', ['members' => $members, 'group' => $group]);
    }

    public function updateMembers(Request $request, Group $group)
    {
        $incomingMembers = $request->input('members');

        // Handle adding/updating members
        foreach ($incomingMembers as $memberData) {
            $group->members()->updateOrCreate(
                ['user_id' => $memberData['user_id']],
                ['role' => $memberData['role'], 'active' => $memberData['active']]
            );
        }

        // Handle removing members
        $incomingMemberIds = array_column($incomingMembers, 'user_id');
        $group->members()->whereNotIn('user_id', $incomingMemberIds)->delete();

        return response()->json(['message' => 'Members updated successfully.']);
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