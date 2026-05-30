<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use App\Models\User;
use Illuminate\Auth\Events\Registered;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Override the default redirect path after login.
     */
    public function redirectPath()
    {
        return '/';
    }

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function login(Request $request)
    {
        $this->validateLogin($request);

        $user = User::where($this->username(), $request->{$this->username()})->first();

        if ($user && !$user->hasVerifiedEmail()) {
            // Do NOT log the user in; redirect to verification notice with guidance
            return $this->unverifiedUser($request, $user);
        }

        if ($this->attemptLogin($request)) {
            if ($request->hasSession()) {
                $request->session()->put('auth.password_confirmed_at', time());
            }

            return $this->sendLoginResponse($request);
        }

        return $this->sendFailedLoginResponse($request);
    }

    protected function unverifiedUser(Request $request, $user)
    {
        try {
            $user->sendEmailVerificationNotification();
        } catch (\Throwable $e) {
            \Log::error("Failed to resend verification email on login attempt for {$user->email}: " . $e->getMessage());
        }

        if ($request->wantsJson()) {
            return response()->json([
                'success' => false,
                'message' => __('Your email address is not verified.'),
                'verification_required' => true,
                'verification_email_resent' => true,
            ], 403);
        }

        return redirect()->route('verification.notice')->with([
            'email' => $user->email,
            'message' => __('Your email address is not verified. We just sent you a new verification link — please check your inbox.')
        ]);
    }

    protected function authenticated(Request $request, $user)
    {
        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'redirect' => $request->input('redirect', $this->redirectPath())
            ]);
        }

        if ($request->has('redirect')) {
            return redirect($request->input('redirect'));
        }

        return redirect()->intended($this->redirectPath());
    }

    protected function sendFailedLoginResponse(Request $request)
    {
        if ($request->wantsJson()) {
            return response()->json([
                'success' => false,
                'message' => trans('auth.failed')
            ], 422);
        }

        throw ValidationException::withMessages([
            $this->username() => [trans('auth.failed')],
        ]);
    }

    protected function showLoginForm(Request $request)
    {
        $redirect = $request->input('redirect');
        return view('auth.login', compact('redirect'));
    }

    public function resendVerificationEmail(Request $request)
    {
        $user = User::where('email', $request->email)->first();

        if ($user && !$user->hasVerifiedEmail()) {
            event(new Registered($user));

            return back()->with('resent', true);
        }

        return back()->with('error', 'Unable to resend verification email.');
    }
}