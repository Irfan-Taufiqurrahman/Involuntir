<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class FundraiserMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $user = auth('api')->user();

        if ($user->role == 'Fundraiser' || $user->role == 'Volunteer') {
            return $next($request);
        }

        return response()->json(['status' => 'Forbidden'], 403);
    }
}
