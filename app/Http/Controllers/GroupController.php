<?php

namespace App\Http\Controllers;

use App\Models\Group;
use Illuminate\Http\Request;

class GroupController extends Controller
{

    public function groupsPage()
    {
        return view('groups.group');
    }

    public function index(Request $request)
    {
        $search = $request->query('search');

        if($search) {
            $groups = Group::where('group_name', 'LIKE', "%{$search}%")
                             ->orWhere('symbol', 'LIKE', "%{$search}%")
                             // ... add other fields if needed
                             ->paginate(15);
        } else {
            $groups = Group::paginate(15);
        }

        return view('admin.groups.index', compact('groups'));
    }

    public function create()
    {
        return view('admin.groups.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            // Validation rules based on your schema
        ]);
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
}