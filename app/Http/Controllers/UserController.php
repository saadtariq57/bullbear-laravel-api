<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Follower;
use App\Models\AlbumMedia;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;


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
        if ($request->route()->named('admin.groups.*')) {
            return view('admin.users.index', compact('users'));
        } else {
            return response()->json($users);
        }
        
    }

    public function siteUserSearch(Request $request)
    {
        $search = $request->input('query');

        if ($search) {
            $users = User::select(['id', 'name', 'email', 'first_name', 'avatar'])
                                ->where('name', 'LIKE', "%{$search}%")
                                ->orWhere('first_name', 'LIKE', "%{$search}%")
                                ->orWhere('email', 'LIKE', "%{$search}%")
                                ->orWhere('name', 'LIKE', "%{$search}%")
                                ->orderByRaw("CASE WHEN name LIKE '{$search}%' THEN 1 ELSE 2 END, name")
                                ->limit(10)
                                ->get();
        } else {
            $users = [];
        }

        return response()->json($users);
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
        $user = User::where('name', $userName)
        ->withCount(['watchlists', 'posts', 'followers' , 'followings'])
        ->firstOrFail();
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
        // $loggedInFollowers = $loggedInUser->followings()->with('follower:id,name,email,avatar,first_name')->get();
        // $loggedInFollowings = $loggedInUser->followers()->with('following:id,name,email,avatar,first_name')->get();
        $currentFollowers = $loggedInUser->followings()->with('follower:id,name,email,avatar,first_name')->get();
        $currentFollowings = $loggedInUser->followers()->with('following:id,name,email,avatar,first_name')->get();

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
            // 'loggedInFollowers' => $loggedInFollowers,
            // 'loggedInFollowings' => $loggedInFollowings,
            'currentFollowerUserData' => $currentFollowers,
            'currentFollowingsUserData' => $currentFollowings,
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
            // $user->update(['cover' => 'photos/d-cover.jpg' , 'cover_position' => '0px']);
            $user->cover = 'photos/d-cover.jpg';
            $user->cover_position = '0px';
            $user->save();
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
    public function updateUserData(Request $request)
    {
        $user = Auth::user();

        // Validate the request data except for name, email, and subscription_plan
        // $validatedData = $request->validate([
        //     'phone_number' => 'required|string|max:255',
        //     'first_name' => 'nullable|string|max:255',
        //     'last_name' => 'nullable|string|max:255',
        //     'about' => 'nullable|string',
        //     'gender' => 'nullable|string|in:male,female,other',
        //     'birthday' => 'nullable|date',
        //     'country' => 'nullable|string|max:255',
        //     'city' => 'nullable|string|max:255',
        //     'zip' => 'nullable|string|max:255',
        //     'website' => 'nullable|string|max:255'
        // ]);

        // Update user with validated data
        // $user->update($validatedData);

        $dataToUpdate = $request->only([
            'phone_number', 
            'first_name', 
            'last_name', 
            'about', 
            'gender', 
            'birthday', 
            'country', 
            'city', 
            'zip', 
            'website',
            'twitter',
            'linkedin',
            'youtube'
        ]);
    
        // Update the user with the data
        $user->update($dataToUpdate);

        return response()->json([
            'message' => 'User updated successfully.',
            'user' => $user
        ]);
    }

    public function updatePrivacySettings(Request $request)
    {
        // Get the authenticated user
        $user = Auth::user();

        // Validate the request
        $request->validate([
            'status_privacy' => 'required|string',
            'search_index_privacy' => 'required|string',
            'my_posts_privacy' => 'required|string',
            'groups_privacy' => 'required|string',
            'watchlist_privacy' => 'required|string',
            'photos_privacy' => 'required|string',
            'follow_privacy' => 'required|string',
        ]);

        // Update the user's privacy settings
        $user->update([
            'status_privacy' => $request->input('status_privacy'),
            'search_index_privacy' => $request->input('search_index_privacy'),
            'post_privacy' => $request->input('my_posts_privacy'),
            'groups_privacy' => $request->input('groups_privacy'),
            'watchlists_privacy' => $request->input('watchlist_privacy'),
            'photos_privacy' => $request->input('photos_privacy'),
            'follow_privacy' => $request->input('follow_privacy'),
        ]);

        // Redirect back with a success message
        return response()->json([
            'message' => 'Privacy setting updated successfully.',
            'user' => $user
        ]);
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'currentPassword' => 'required',
            'newPassword' => 'required|min:8|confirmed',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->currentPassword, $user->password)) {
            throw ValidationException::withMessages([
                'currentPassword' => ['The provided password does not match your current password.'],
            ]);
        }

        $user->password = Hash::make($request->newPassword);
        $user->save();

        return response()->json(['message' => 'Password updated successfully.'], 200);
    }

    public function defaultMembers()
    {
        // Fetch default members from the database or any other source
        $defaultMembers = User::orderBy('created_at', 'desc')->take(30)->get(); // Example: Fetching 10 latest members
        return response()->json($defaultMembers);
    }
}