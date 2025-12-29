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
        // For API requests, return 401 instead of redirecting to web/admin login
        if ($request->is('api/*')) {
            return null;
        }

        return $request->expectsJson() ? null : route('admin.login');
    }
}
