<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (! auth()->check() || auth()->user()->role !== 'Admin') {
            auth()->logout();
            // abort(403);
            return redirect('/');
        }

        return $next($request);
    }
}
