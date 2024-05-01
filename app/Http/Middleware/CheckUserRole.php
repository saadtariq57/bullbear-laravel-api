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
        // Check if the user is authenticated
        if (!Auth::check()) {
            return redirect('/login'); // Redirect to the login page or wherever you wish
        }

        // Get the authenticated user
        $user = Auth::user();

        // Check if the user's type is 'admin'
        if ($user->type === 'admin') {
            return $next($request); // Allow admin users to proceed
        }
        

        // Redirect non-admin users to the /feed route
        return redirect('/feed');
    }
}