<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;


class AdminManagementAccessMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $user = auth()->user();

        if (!$user || !in_array($user->role, ['superadmin', 'admin'])) {
            abort(403, 'Unauthorized');
        }

        return $next($request);
    }
}
