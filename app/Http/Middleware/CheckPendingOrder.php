<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;


class CheckPendingOrder
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            $pendingOrder = Order::where('user_id', Auth::id())
                ->where('status', 'pending')
                ->first();

            if (!$pendingOrder) {
                return redirect()->route('home');
            }
        }

        return $next($request);
    }
}
