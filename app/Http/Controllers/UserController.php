<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Follower;
use App\Models\AlbumMedia;
use App\Models\Post;
use App\Models\SubscriptionPlan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;


class UserController extends Controller
{

    public function index(Request $request)
    {
        $search = $request->query('search');

        if($search) {
            $users = User::with('subscriptionPlan')
                ->where('name', 'LIKE', "%{$search}%")
                ->orWhere('email', 'LIKE', "%{$search}%")
                ->paginate(15);
        } else {
            $users = User::with('subscriptionPlan')->paginate(15);
        }
        if ($request->route()->named('admin.groups.*') || $request->route()->named('admin.users.*')) {
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
                             ->limit(10) 
                             ->get();
        } else {
            $users = [];
        }

        return response()->json($users);
    }

    public function create()
    {
        $subscriptionPlans = SubscriptionPlan::all();
        return view('admin.users.create', compact('subscriptionPlans'));
    }

    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'name' => 'required|string|max:255|unique:users',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:8',
                'first_name' => 'nullable|string|max:100',
                'last_name' => 'nullable|string|max:32',
                'type' => 'required|in:user,admin,bot',
                'status' => 'required|in:active,inactive',
                'subscription_plan_id' => 'nullable|exists:subscription_plans,id',
                'gender' => 'nullable|in:male,female,other',
                'birthday' => 'nullable|date',
                'phone_number' => 'nullable|string|max:32',
                'city' => 'nullable|string|max:50',
                'state' => 'nullable|string|max:50',
                'zip' => 'nullable|string|max:11',
                'about' => 'nullable|string',
            ]);

            // Hash the password
            $validatedData['password'] = Hash::make($validatedData['password']);

            // Handle empty subscription_plan_id
            if (empty($validatedData['subscription_plan_id'])) {
                $validatedData['subscription_plan_id'] = null;
            }

            User::create($validatedData);
            return redirect()->route('admin.users.index')->with('success', 'User created successfully');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()
                ->withErrors($e->validator)
                ->withInput()
                ->with('error', 'Validation failed: ' . $e->getMessage());
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'An error occurred while creating the user: ' . $e->getMessage());
        }
    }

    public function edit(User $user)
    {
        $subscriptionPlans = SubscriptionPlan::all();
        return view('admin.users.edit', compact('user', 'subscriptionPlans'));
    }

    public function update(Request $request, User $user)
    {
        try {
            $validatedData = $request->validate([
                'name' => 'required|string|max:255|unique:users,name,' . $user->id,
                'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
                'password' => 'nullable|string|min:8',
                'first_name' => 'nullable|string|max:100',
                'last_name' => 'nullable|string|max:32',
                'type' => 'required|in:user,admin,bot',
                'status' => 'required|in:active,inactive',
                'subscription_plan_id' => 'nullable|exists:subscription_plans,id',
                'gender' => 'nullable|in:male,female,other',
                'birthday' => 'nullable|date',
                'phone_number' => 'nullable|string|max:32',
                'city' => 'nullable|string|max:50',
                'state' => 'nullable|string|max:50',
                'zip' => 'nullable|string|max:11',
                'about' => 'nullable|string',
            ]);

            // Only hash password if it's provided
            if (!empty($validatedData['password'])) {
                $validatedData['password'] = Hash::make($validatedData['password']);
            } else {
                unset($validatedData['password']);
            }

            // Handle empty subscription_plan_id
            if (empty($validatedData['subscription_plan_id'])) {
                $validatedData['subscription_plan_id'] = null;
            }

            $user->update($validatedData);
            return redirect()->route('admin.users.index')->with('success', 'User updated successfully');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()
                ->withErrors($e->validator)
                ->withInput()
                ->with('error', 'Validation failed: ' . $e->getMessage());
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'An error occurred while updating the user: ' . $e->getMessage());
        }
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'User deleted successfully');
    }

    /*public function getUserData()
    {
        // Get the authenticated user
        $authenticatedUser = Auth::user();

        if ($authenticatedUser) {
            $userData = User::where('id', $authenticatedUser->id)
                        ->withCount(['watchlists', 'posts', 'followers'])
                        ->first();
            return response()->json($userData);
        } else {

            return response()->json(['error' => 'Unauthenticated'], 401);
        }
    }*/

    public function getUserData()
    {
        // Get the authenticated user
        $authenticatedUser = Auth::user();

        if ($authenticatedUser) {
            // Fetch user data with counts and related relationships
            $userData = User::where('id', $authenticatedUser->id)
                ->withCount(['watchlists', 'posts', 'followers', 'followings'])
                ->with([
                    'followingsUser:id',
                    'groups:id'
                ])
                ->first();

            // Check if userData is found
            if (!$userData) {
                return response()->json(['error' => 'User not found'], 404);
            }

            $userArray = $userData->toArray();

            $userArray['following'] = $userData->followingsUser->pluck('id')->toArray();
            
            $userArray['groups_info'] = $userData->groups->map(function ($group) {
                return [
                    'id' => $group->id,
                    'status' => $group->pivot['status'],
                ];
            })->toArray();
            unset($userArray['followings_user']);
            unset($userArray['groups']);

            return response()->json($userArray);
        } else {
            return response()->json(['error' => 'Unauthenticated'], 401);
        }
    }

    /**
     * Get the profile data of a user by username.
     */
    public function getUserProfileData($userName)
    {
        $user = User::where('name', $userName)
            ->withCount(['watchlists', 'posts', 'followers', 'followings'])
            ->firstOrFail();

        $loggedInUser = Auth::user();
        $isFollowing = false;
        $isOwnProfile = false;

        if ($loggedInUser) {
            $isFollowing = Follower::where('follower_id', $loggedInUser->id)
                ->where('following_id', $user->id)
                ->exists();

            if ($user->id === $loggedInUser->id) {
                $isOwnProfile = true;
            }
        }

        $postIds = Post::where('user_id', $user->id)->pluck('id');
        $photos = AlbumMedia::whereIn('post_id', $postIds)->get();

        // Optimize follower and following counts
        $followersCount = $user->followers_count;
        $followingsCount = $user->followings_count;

        $followers = $user->followers()->with('follower:id,name,email,avatar,first_name')->get();
        $followings = $user->followings()->with('following:id,name,email,avatar,first_name')->get();

        // Current user's followers and followings
        $currentFollowers = $loggedInUser ? $loggedInUser->followers()->with('follower:id,name,email,avatar,first_name')->get() : collect();
        $currentFollowings = $loggedInUser ? $loggedInUser->followings()->with('following:id,name,email,avatar,first_name')->get() : collect();

        // Check active status for the user being viewed
        $session = DB::table('sessions')
            ->where('user_id', $user->id)
            ->orderBy('last_activity', 'desc')
            ->first();

        if (!$session) {
            $activeStatus = 'Offline';
        } else {
            $lastActivity = Carbon::createFromTimestamp($session->last_activity);
            $activeStatus = $lastActivity->diffInSeconds(Carbon::now()) <= 600 ? 'Online' : 'Offline';
        }

        return response()->json([
            'userProfile' => $user, 
            'isOwnProfile' => $isOwnProfile, 
            'userMedia' => $photos,
            'isFollowing' => $isFollowing,
            'followersCount' => $followersCount,
            'followingsCount' => $followingsCount,
            'followerUserData' => $followers,
            'followingsUserData' => $followings,
            'currentFollowerUserData' => $currentFollowers,
            'currentFollowingsUserData' => $currentFollowings,
            'active_status' => $activeStatus,
        ]);
    }

    /*public function getUserProfileData($userName)
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
    }*/

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
            'cover_photo' => 'required|image|mimes:jpeg,png,jpg|max:2048',
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

        // Validate inputs (URLs and phone formats)
        $validatedData = $request->validate([
            'phone_number' => ['nullable','string','max:32','regex:/^[+]?([0-9\-\.\s\(\)]){7,20}$/'],
            'first_name' => 'nullable|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'about' => 'nullable|string',
            'gender' => 'nullable|string|in:male,female,other',
            'birthday' => 'nullable|date',
            'country' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'zip' => 'nullable|string|max:255',
            'website' => 'nullable|url|max:255',
        ]);

        $dataToUpdate = $validatedData ?: $request->only([
            'phone_number', 
            'first_name', 
            'last_name', 
            'about', 
            'gender', 
            'birthday', 
            'country', 
            'city', 
            'zip', 
            'website'
        ]);
    
        // Update the user with the data
        $user->update($dataToUpdate);

        return response()->json([
            'message' => 'User updated successfully.',
            'user' => $user
        ]);
    }

    public function updateSocialLinks(Request $request)
    {
        $user = Auth::user();

        $validatedData = $request->validate([
            'twitter' => 'nullable|url|max:255',
            'linkedin' => 'nullable|url|max:255',
            'youtube' => 'nullable|url|max:255',
        ]);

        $dataToUpdate = $validatedData ?: $request->only([
            'twitter',
            'linkedin',
            'youtube',
        ]);

        $user->update($dataToUpdate);

        return response()->json([
            'message' => 'Social links updated successfully.',
            'user' => $user
        ]);
    }

    public function updatePrivacySettings(Request $request)
    {
        // Get the authenticated user
        $user = Auth::user();

        // Validate the request
        $request->validate([
            'post_privacy' => 'required|string',
            'groups_privacy' => 'required|string',
            'watchlists_privacy' => 'required|string',
            'photos_privacy' => 'required|string',
        ]);

        // Update the user's privacy settings
        $user->update([
            'post_privacy' => $request->input('post_privacy'),
            'groups_privacy' => $request->input('groups_privacy'),
            'watchlists_privacy' => $request->input('watchlists_privacy'),
            'photos_privacy' => $request->input('photos_privacy'),
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
            'currentPassword' => ['required','string'],
            'newPassword' => [
                'required',
                'string',
                'min:8',
                'confirmed',
                'regex:/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[!@#$%^&*()\-_=+{};:,<.>]).{8,}$/'
            ],
        ], [
            'newPassword.regex' => 'Password must be at least 8 chars and include upper, lower, number, and symbol.',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->currentPassword, $user->password)) {
            throw ValidationException::withMessages([
                'currentPassword' => ['The provided password does not match your current password.'],
            ]);
        }

        // Prevent reusing the same password
        if (Hash::check($request->newPassword, $user->password)) {
            return response()->json([
                'message' => 'New password must be different from current password.',
                'errors' => ['newPassword' => ['New password must be different from current password.']]
            ], 422);
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