<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticatedUser
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            $user = Auth::user();
            if ($user->type === 'customer') {
                return redirect()->route('shop');
            } elseif ($user->type === 'seller') {
                return redirect()->route('seller');
            }
        }

        return $next($request);
    }
}
