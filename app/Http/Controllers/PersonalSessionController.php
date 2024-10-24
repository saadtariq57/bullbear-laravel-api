<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PersonalSession;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\SessionBooked;
use App\Mail\SessionConfirmed;
use App\Mail\SessionCancelled;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class PersonalSessionController extends Controller
{
    
    public function index(Request $request)
    {
        $user = Auth::user();

        // Optional: Implement search or filter by user
        $query = PersonalSession::with('user')->orderBy('scheduled_at', 'desc');

        if ($request->filled('user_id')) {
            $query->where('user_id', $request->input('user_id'));
        }

        // Pagination
        $sessions = $query->paginate(10)->withQueryString();

        // Fetch all users for filter dropdown
        $users = User::orderBy('name')->get();

        return view('admin.sessions.index', compact('sessions', 'users'));
    }


    /**
     * Show the form for creating a new session.
     */
    public function create()
    {
        $user = Auth::user();

        // Fetch all users to select from
        $users = User::orderBy('name')->get();

        return view('admin.sessions.create', compact('users'));
    }


    /**
     * Store a newly created session in storage.
     */
    public function store(Request $request)
    {
        $admin = Auth::user();

        // Validate input, including user_id
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'scheduled_at' => 'required|date|after:now',
        ]);

        $selectedUser = User::findOrFail($request->input('user_id'));

        // Determine the feature name based on the user's plan
        $featureName = $selectedUser->hasFeature('monthly_personal_sessions') ? 'monthly_personal_sessions' : 'monthly_personal_session';

        // Check if the selected user can access the feature
        if (Gate::forUser($selectedUser)->denies('access-feature', $featureName)) {
            return redirect()->back()->with('error', 'The selected user has reached their session limit or does not have access to this feature.');
        }

        // Create session
        $session = PersonalSession::create([
            'user_id'      => $selectedUser->id,
            'scheduled_at' => $request->input('scheduled_at'),
            'status'       => 'pending',
            'feature'      => $featureName,
        ]);

        // Optional: Send confirmation email or other notifications to the user

        return redirect()->route('admin.sessions.index')->with('success', 'Session booked successfully for ' . $selectedUser->name . '.');
    }


    /**
     * Display the specified session.
     */
    public function show(PersonalSession $personalSession)
    {

        $personalSession->load('user');

        return view('admin.sessions.show', compact('personalSession'));
    }


    /**
     * Show the form for editing the specified session.
     */
    public function edit(PersonalSession $personalSession)
    {

        $personalSession->load('user');

        // Fetch all users to allow changing the session's user
        $users = User::orderBy('name')->get();

        return view('admin.sessions.edit', compact('personalSession', 'users'));
    }


    /**
     * Update the specified session in storage.
     */
    public function update(Request $request, PersonalSession $personalSession)
    {

        // Validate input, including user_id if it's being updated
        $request->validate([
            'user_id' => 'sometimes|exists:users,id',
            'scheduled_at' => 'required|date|after:now',
            'status' => 'required|in:pending,confirmed,completed,cancelled',
        ]);

        $oldStatus = $personalSession->status;
        // If user_id is being updated
        if ($request->has('user_id')) {
            $selectedUser = User::findOrFail($request->input('user_id'));
            $featureName = $selectedUser->hasFeature('monthly_personal_sessions') ? 'monthly_personal_sessions' : 'monthly_personal_session';

            // Check if the selected user can access the feature
            // if (Gate::forUser($selectedUser)->denies('access-feature', $featureName)) {
            //     return redirect()->back()->with('error', 'The selected user has reached their session limit or does not have access to this feature.');
            // }

            $personalSession->user_id = $selectedUser->id;
            $personalSession->feature = $featureName;
        }

        // Update other fields
        $personalSession->scheduled_at = $request->input('scheduled_at');
        $personalSession->status = $request->input('status');
        $personalSession->meet_link = $request->input('meetLink');

        $personalSession->save();

        $personalSession->load('user');
        if($oldStatus != 'confirmed' && $personalSession->status == 'confirmed'){
            // \Log::info("Session Booking Details: " . json_encode($personalSession));
            Mail::to($personalSession->user->email)->send(new SessionConfirmed($personalSession->user, $personalSession));
        }else if($oldStatus != 'cancelled' && $personalSession->status == 'cancelled'){
            \Log::info("Session Booking Cancelled Details: " . json_encode($personalSession));
            Mail::to($personalSession->user->email)->send(new SessionCancelled($personalSession->user, $personalSession));
        }
        
        return redirect()->route('admin.sessions.index')->with('success', 'Session updated successfully.');
    }


    /**
     * Remove the specified session from storage.
     */
    public function destroy(PersonalSession $personalSession)
    {

        $personalSession->delete();

        return redirect()->route('admin.sessions.index')->with('success', 'Session deleted successfully.');
    }


    /* Front End Api Methods */
    public function userUpdate(Request $request, $id)
    {
        $user = Auth::user();
        $personalSession = PersonalSession::where('id', $id)->where('user_id', $user->id)->first();

        if (!$personalSession) {
            return response()->json([
                'success' => false,
                'message' => 'Session not found or you do not have permission to update this session.',
            ], 404);
        }

        // Check if the session is in the future
        if ($personalSession->scheduled_at < now()) {
            return response()->json([
                'success' => false,
                'message' => 'You can only cancel a session before its scheduled date and time.',
            ], 403);
        }

        // Validate input
        $request->validate([
            'status' => 'required|in:cancelled',
        ]);

        // Update session status to cancelled
        $personalSession->update([
            'status' => $request->input('status'),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Session status updated successfully.',
            'data' => $personalSession,
        ]);
    }

    /**
     * Return a list of user's personal sessions in JSON format.
     */
    public function userIndex()
    {
        $user = Auth::user();
        $sessions = $user->personalSessions()->orderBy('scheduled_at', 'desc')->paginate(10);

        return response()->json([
            'success' => true,
            'data' => $sessions,
        ]);
    }

    /**
     * Store a new personal session and return JSON response.
     */
    public function userStore(Request $request)
    {
        $user = Auth::user();

        // Validate input
        $request->validate([
            'scheduled_at' => 'required|date|after:now',
        ]);

        // Determine the feature name based on the user's plan
        $featureName = $user->hasFeature('monthly_personal_sessions') ? 'monthly_personal_sessions' : 'monthly_personal_session';

        // Check Gate
        if (Gate::denies('access-feature', $featureName)) {
            return response()->json([
                'success' => false,
                'message' => 'You have reached your session limit or do not have access to this feature.',
            ], 403);
        }
        $session = PersonalSession::create([
            'user_id'     => $user->id,
            'scheduled_at'=> $request->input('scheduled_at'),
            'status'      => 'pending',
            'feature'     => $featureName,
        ]);

        // \Log::info("Session Booking Details: " . json_encode($session));

        // Send the email
        Mail::to($user->email)->send(new SessionBooked($user, $session));

        return response()->json([
            'success' => true,
            'message' => 'Session booked successfully.',
            'data' => $session,
        ]);
      
    }
}
