<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;
use Tymon\JWTAuth\JWTAuth;

class VerificationEmail
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
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
