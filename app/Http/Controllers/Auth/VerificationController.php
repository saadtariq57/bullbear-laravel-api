<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\VerifiesEmails;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Auth\Events\Verified;
use Illuminate\Support\Facades\Mail;
use App\Mail\WelcomeEmail;
use Illuminate\Support\Facades\Auth;

class VerificationController extends Controller
{
    use VerifiesEmails;

    protected $redirectTo = '/feed';

    public function __construct()
    {
        $this->middleware('throttle:6,1')->only('verify', 'resend');
    }

    public function show(Request $request)
    {
        if ($request->user() && $request->user()->hasVerifiedEmail()) {
            return redirect($this->redirectPath());
        }

        return view('auth.verify', ['email' => $request->session()->get('email')]);
    }

    public function verify(Request $request)
    {
        $user = User::find($request->route('id'));

        if (!$user) {
            return redirect()->route('login')->with('error', 'User not found.');
        }

        if (!hash_equals((string) $request->route('hash'), sha1($user->getEmailForVerification()))) {
            return redirect()->route('login')->with('error', 'Invalid verification link.');
        }

        if ($user->hasVerifiedEmail()) {
            return redirect($this->redirectPath());
        }

        if ($user->markEmailAsVerified()) {
            event(new Verified($user));

            // Sending the welcome email after verification
            try {
                // Log before sending the email to track its progress
                // \Log::info("Sending welcome email to {$user->email}");
        
                Mail::to($user->email)->send(new \App\Mail\WelcomeEmail($user));
        
                // Log after the email is sent
                // \Log::info("Welcome email sent to {$user->email}");
            } catch (\Exception $e) {
                // Log error if email sending fails
                \Log::error("Failed to send welcome email to {$user->email}: " . $e->getMessage());
            }
        }

        Auth::login($user);

        $intendedCheckout = $request->session()->pull('intended_checkout_url');

        return redirect($intendedCheckout ?? $this->redirectPath())->with('verified', true);
    }

    public function resend(Request $request)
    {
        if ($request->user()) {
            if ($request->user()->hasVerifiedEmail()) {
                return redirect($this->redirectPath());
            }

            $request->user()->sendEmailVerificationNotification();
        } else {
            $user = User::where('email', $request->email)->first();
            if ($user) {
                $user->sendEmailVerificationNotification();
            }
        }

        return back()->with('resent', true);
    }
}