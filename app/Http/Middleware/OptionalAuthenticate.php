<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\PersonalAccessToken;

class OptionalAuthenticate
{
    /**
     * Handle an incoming request.
     * Try to authenticate the user if a token is present, but don't fail if it's not.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Check if Authorization header is present
        $token = $request->bearerToken();

        if ($token) {
            // Try to authenticate using Sanctum
            $accessToken = PersonalAccessToken::findToken($token);

            if ($accessToken) {
                // Set the authenticated user
                Auth::setUser($accessToken->tokenable);
            }
        }

        // Continue with the request whether authenticated or not
        return $next($request);
    }
}
