<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckUserRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Not authenticated: send them to the admin login page.
        if (!Auth::check()) {
            return redirect()->route('admin.login');
        }

        $user = Auth::user();

        // Allow admin and robot users to proceed.
        if ($user->type === 'admin' || $user->type === 'robot') {
            return $next($request);
        }

        // Authenticated but not an admin: bounce back to the admin login with a
        // message. The admin login screen will clear the non-admin session.
        return redirect()->route('admin.login')
            ->with('error', 'You do not have permission to access the admin panel.');
    }
}