<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        if ($request->expectsJson()) {
            return null;
        }

        // Admin-panel requests get their own self-contained login page rather
        // than being bounced to the Next.js frontend.
        $adminDomain = config('app.admin_domain');
        $isAdminArea = ($adminDomain && $request->getHost() === $adminDomain)
            || (! $adminDomain && $request->is('admin', 'admin/*'));

        return $isAdminArea ? route('admin.login') : route('login');
    }
}
