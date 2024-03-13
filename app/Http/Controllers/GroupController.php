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

    public function index(Request $request)
    {
        $search = $request->query('search');

        if ($search) {
            $groups = Group::withCount('members')
                            ->where('group_name', 'LIKE', "%{$search}%")
                            ->orWhere('symbol', 'LIKE', "%{$search}%")
                            ->paginate(15);
        } else {
            $groups = Group::withCount('members')->paginate(15);
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
        $validatedData = $request->validate([
            'group_name' => 'required|string|max:255',
            'group_title' => 'required|string|max:255',
            'about' => 'nullable|string',
            'symbol' => 'nullable|string',
            'exchange' => 'nullable|string',
            'category_id' => 'required|exists:group_categories,id',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $userId = auth()->id(); 
        $validatedData['user_id'] = $userId;
        $validatedData['privacy'] = $request->has('privacy') ? 'private' : 'public';
        $validatedData['active'] = $request->input('active') === 'on' ? '1' : '0';

        if ($request->hasFile('avatar')) {
            $year = date('Y');
            $month = date('m');
            $directory = "uploads/photos/{$year}/{$month}";

            // Ensure the directory exists
            if (!Storage::disk('public')->exists($directory)) {
                Storage::disk('public')->makeDirectory($directory);
            }

            // Store the file in the directory
            $path = $request->file('avatar')->store($directory, 'public');

            // Check if the file was uploaded successfully
            if (!$path) {
                return back()->withErrors(['avatar' => 'The avatar could not be uploaded.'])->withInput();
            }

            // Update the path to remove 'uploads/' if needed
            $validatedData['avatar'] = $path;
        }

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
            // Validation rules based on your schema
        ]);
        $group->update($validatedData);
        return redirect()->route('admin.groups.index')->with('success', 'Group updated successfully');
    }

    public function destroy(Group $group)
    {
        $group->delete();
        return redirect()->route('admin.groups.index')->with('success', 'Group deleted successfully');
    }

    // Group category Methods

    public function categoriesIndex(Request $request)
    {
        $search = $request->query('search');
        if ($search) {
            $categories = GroupCategory::where('name', 'LIKE', "%{$search}%")
                ->paginate(15);
        } else {
            $categories = GroupCategory::paginate(15);
        }
        
        return view('admin.groups.categories.index', compact('categories'));
    }

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
            // other validation rules
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