<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class Role
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next, $role)
    {
        Log::info('User Role:', ['actual' => Auth::check() ? Auth::user()->role : 'guest', 'expected' => $role]);
        Log::info('Logged in user ID: ' . Auth::id());


        if (!Auth::check() || trim(strtolower(Auth::user()->role)) !== trim(strtolower($role))) {
            abort(403, 'Unauthorized');
        }

        return $next($request);
    }
}
