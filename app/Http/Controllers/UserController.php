<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Follower;
use App\Models\AlbumMedia;
use App\Models\Post;
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
        $authenticatedUser = Auth::user();

        // Check if the user is authenticated
        if ($authenticatedUser) {
            // Retrieve data for the authenticated user with additional counts
            // $userData = $authenticatedUser->withCount(['watchlists', 'posts', 'followers'])
            //                               ->first();
            $userData = User::where('id', $authenticatedUser->id)
                        ->withCount(['watchlists', 'posts', 'followers'])
                        ->first();
            return response()->json($userData);
        } else {
            // Return an error response if the user is not authenticated
            return response()->json(['error' => 'Unauthenticated'], 401);
        }
    }

    public function getUserProfileData($userName)
    {
        $user = User::where('name', $userName)->firstOrFail();
        $loggedInUser = Auth::user();
        $userId = null;
        $isFollowing = false;
        if ($loggedInUser) {
            $isFollowing = Follower::where('follower_id', $loggedInUser->id)
                ->where('following_id', $user->id)
                ->exists();
        }
        if($user->id === $loggedInUser->id){
            $isOwnProfile = true;
            $userId = $loggedInUser->id;
        }else{
            $isOwnProfile = false;
            $userId = $user->id;
        }
        $postIds = Post::where('user_id', $userId)->pluck('id');
        $photos = AlbumMedia::whereIn('post_id', $postIds)->get();
        $followersCount = Follower::where('following_id', $user->id)->count();
        $followingsCount = Follower::where('follower_id', $user->id)->count();
        $followers = $user->followings()->with('follower:id,name,email,avatar,first_name')->get();
        $followings = $user->followers()->with('following:id,name,email,avatar,first_name')->get();
        // 'following:id,name,email,avatar,first_name'
        // if ($photos->isEmpty()) {
        //     $photos = 'No Media Found';
        // }
        return response()->json([
            'userProfile' => $user, 
            'isOwnProfile' => $isOwnProfile, 
            'userMedia' => $photos,
            'isFollowing' => $isFollowing,
            'followersCount' => $followersCount,
            'followingsCount' => $followingsCount,
            'followerUserData' => $followers,
            'followingsUserData' => $followings,
        ]);
    }

    // public function getUserAlbumData()
    // {
    //     $user = Auth::user();
    //     if ($user) {
    //         $postIds = Post::where('user_id', $user->id)->pluck('id');
    //         $photos = AlbumMedia::whereIn('post_id', $postIds)->get();
    //         if ($photos->isEmpty()) {
    //             return response()->json(['message' => 'No media found'], 404);
    //         }
    //         return response()->json($photos);
    //     } else {
    //         return response()->json(['error' => 'Unauthenticated'], 401);
    //     }
    // }

    public function updateCoverPhoto(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'cover_photo' => 'required|image|mimes:jpeg,png,jpg|max:2048', // Add validation for cover photo
        ]);

        // Upload cover photo
        try {
            $coverPhotoPath = $request->file('cover_photo')->store('/photos', 'public');
            // Update cover photo path in user model
            $user->update(['cover' => $coverPhotoPath]);
        } catch (\Exception $e) {
            Log::error("Cover photo upload failed: " . $e->getMessage());
            return response()->json(['error' => 'Failed to upload cover photo'], 500);
        }

        return response()->json(['success' => true, 'message' => 'Cover photo uploaded successfully', 'cover_photo' => $coverPhotoPath]);
    }

    public function removeCoverPhoto(Request $request){
        $user = Auth::user();
        try {
            $user->update(['cover' => 'photos/d-cover.jpg']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to remove cover photo'], 500);
        }

        return response()->json(['message' => 'Cover photo removed successfully']);
    }

    public function updateProfilePhoto(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'profile_photo' => 'required|image|mimes:jpeg,png,jpg|max:2048', // Add validation for cover photo
        ]);

        // Upload cover photo
        try {
            $profilePhotoPath = $request->file('profile_photo')->store('/photos', 'public');
            // Update cover photo path in user model
            $user->update(['avatar' => $profilePhotoPath]);
        } catch (\Exception $e) {
            Log::error("profile photo upload failed: " . $e->getMessage());
            return response()->json(['error' => 'Failed to upload profile photo'], 500);
        }

        return response()->json(['message' => 'Profile photo updated successfully', 'profile_photo' => $profilePhotoPath]);
    }
    public function updateCoverPosition(Request $request)
    {
        $user = auth()->user(); // Assuming you are using authentication
        $user->cover_position = $request->input('cover_position');
        $user->save();

        return response()->json(['message' => 'Cover position updated successfully'], 200);
    }
    
}