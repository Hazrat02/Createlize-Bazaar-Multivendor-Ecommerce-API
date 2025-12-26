<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SetAdminSessionCookie
{
    public function handle(Request $request, Closure $next)
    {
        config([
            'session.cookie' => env('ADMIN_SESSION_COOKIE', 'admin_session'),
            'session.path' => '/admin',
        ]);

        return $next($request);
    }
}
