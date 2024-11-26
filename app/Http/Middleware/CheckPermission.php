<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckPermission {
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $permission): Response {
        $user = Auth::user();
        if (!$user || !$user->hasRole($permission)) {
            return response()->json(['status' => 'failed', 'response' => 'Unauthorized'], 403);
        }

        return $next($request);
    }
}