<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

/**
 * Self-contained authentication for the Blade admin panel.
 *
 * This is intentionally separate from the customer-facing LoginController
 * (which the Next.js frontend uses via Sanctum). Only users whose `type` is
 * "admin" or "robot" are allowed to establish an admin session here.
 */
class AdminLoginController extends Controller
{
    /**
     * Roles allowed to access the admin panel.
     */
    protected array $adminTypes = ['admin', 'robot'];

    public function showLoginForm()
    {
        $user = Auth::user();

        if ($user && $this->isAdmin($user)) {
            return redirect()->route('admin.index');
        }

        // A non-admin session must not linger on the admin login page.
        if ($user) {
            Auth::logout();
        }

        return view('admin.auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        $remember = $request->boolean('remember');

        if (! Auth::attempt($credentials, $remember)) {
            throw ValidationException::withMessages([
                'email' => trans('auth.failed'),
            ]);
        }

        if (! $this->isAdmin(Auth::user())) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            throw ValidationException::withMessages([
                'email' => __('You do not have permission to access the admin panel.'),
            ]);
        }

        $request->session()->regenerate();

        return redirect()->intended(route('admin.index'));
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }

    protected function isAdmin($user): bool
    {
        return $user && in_array($user->type, $this->adminTypes, true);
    }
}
