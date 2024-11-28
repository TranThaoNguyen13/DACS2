<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && Auth::user()->role !== 1) { // Sử dụng Auth::user()
            return redirect('/home'); // Chuyển hướng nếu không phải admin
        }

        return $next($request);
    }
}
