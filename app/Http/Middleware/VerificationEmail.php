<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class VerificationEmail
{
    /**
     * Handle an incoming request.
     *
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (! auth('api')->user() || (auth('api')->user() instanceof MustVerifyEmail && ! auth('api')->user()->hasVerifiedEmail())) {
            return response()->json(['message' => 'Your email address is not verified.'], 403);
        }

        return $next($request);
    }
}
