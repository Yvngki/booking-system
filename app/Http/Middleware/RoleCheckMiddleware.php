<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RoleCheckMiddleware
{
    public function handle($request, Closure $next, ...$roles)
    {
        // Check if the user is authenticated
        if (Auth::check()) {
            // Get the authenticated user
            $user = Auth::user();

             // Map '1' to 'admin' and '0' to 'client'
            $userRole = $user->role === '1' ? 'admin' : 'client';
            
            // Check if the user has the required role
            if (in_array($user->role, $roles)) {
                return $next($request);
            }
        }

        // Redirect or respond with an error (e.g., 403 Forbidden)
        return abort(403, 'Unauthorized.');
    }
}

