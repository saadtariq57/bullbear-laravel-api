<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class UserController extends Controller
{

    public function index(Request $request)
    {
        $search = $request->query('search');

        if($search) {
            $users = User::where('name', 'LIKE', "%{$search}%")
                             ->orWhere('email', 'LIKE', "%{$search}%")
                             // ... add other fields if needed
                             ->paginate(15);
        } else {
            $users = User::paginate(15);
        }

        return view('admin.users.index', compact('users'));
    }

    public function search(Request $request)
    {
        $search = $request->input('query');

        if ($search) {
            $users = User::select(['id', 'name', 'first_name', 'last_name', 'email'])
                             ->where('name', 'LIKE', "%{$search}%")
                             ->orWhere('email', 'LIKE', "%{$search}%")
                             // ... add other fields if needed
                             ->limit(10)  // Limiting to 10 results for dropdown purpose
                             ->get();
        } else {
            $users = [];  // Return empty array if there's no search query
        }

        return response()->json($users);
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            // Validation rules based on your schema
        ]);
        User::create($validatedData);
        return redirect()->route('admin.users.index')->with('success', 'User created successfully');
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $validatedData = $request->validate([
            // Validation rules based on your schema
        ]);
        $user->update($validatedData);
        return redirect()->route('admin.users.index')->with('success', 'User updated successfully');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'User deleted successfully');
    }

    public function getUserData()
    {
        // Get the authenticated user
        $authenticatedUser = auth()->user();

        // Check if the user is authenticated
        if ($authenticatedUser) {
            // Retrieve data for the authenticated user with additional counts
            $userData = $authenticatedUser->withCount(['watchlists', 'posts', 'followers'])
                                          ->first();

            return response()->json($userData);
        } else {
            // Return an error response if the user is not authenticated
            return response()->json(['error' => 'Unauthenticated'], 401);
        }
    }
    
}