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

    protected $redirectTo = '/';

    protected function frontendBaseUrl(): string
    {
        return rtrim((string) config('app.frontend_url'), '/');
    }

    protected function frontendUrl(string $path = ''): string
    {
        if ($path === '') {
            return $this->frontendBaseUrl();
        }

        // If it's already absolute, return as-is.
        if (preg_match('/^https?:\/\//i', $path)) {
            return $path;
        }

        return $this->frontendBaseUrl() . '/' . ltrim($path, '/');
    }

    public function __construct()
    {
        $this->middleware('throttle:6,1')->only('verify', 'resend');
    }

    public function show(Request $request)
    {
        if ($request->user() && $request->user()->hasVerifiedEmail()) {
            return redirect($this->frontendUrl($this->redirectPath()));
        }

        // We no longer render a Blade "verify" page (Vite). Next.js owns the UI.
        $email = $request->session()->get('email');
        $qs = $email ? ('?email=' . urlencode((string) $email)) : '';
        return redirect($this->frontendUrl('/verify-email' . $qs));
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
            return redirect($this->frontendUrl($this->redirectPath()));
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

        if (is_string($intendedCheckout) && $intendedCheckout !== '') {
            return redirect($this->frontendUrl($intendedCheckout))->with('verified', true);
        }

        return redirect($this->frontendUrl($this->redirectPath()))->with('verified', true);
    }

    public function resend(Request $request)
    {
        $expectsJson = $request->expectsJson();

        if ($request->user()) {
            if ($request->user()->hasVerifiedEmail()) {
                if ($expectsJson) {
                    return response()->json([
                        'message' => 'Your email address is already verified.',
                        'already_verified' => true,
                    ]);
                }

                return redirect($this->frontendUrl($this->redirectPath()));
            }

            $user = $request->user();
        } else {
            $user = User::where('email', $request->email)->first();

            if (!$user) {
                if ($expectsJson) {
                    return response()->json([
                        'message' => 'No account was found for that email address.',
                    ], 404);
                }

                return back()->withErrors([
                    'email' => 'No account was found for that email address.',
                ]);
            }
        }

        try {
            $user->sendEmailVerificationNotification();
        } catch (\Throwable $e) {
            \Log::error("Failed to resend verification email for {$user->email}: " . $e->getMessage());

            if ($expectsJson) {
                return response()->json([
                    'message' => 'Could not send the verification email. Please try again later.',
                ], 500);
            }

            return back()->withErrors([
                'email' => 'Could not send the verification email. Please try again later.',
            ]);
        }

        if ($expectsJson) {
            return response()->json([
                'message' => 'Verification email sent.',
                'resent' => true,
            ]);
        }

        return back()->with('resent', true);
    }
}