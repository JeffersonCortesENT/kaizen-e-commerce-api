<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Laravel\Sanctum\PersonalAccessToken;
use Symfony\Component\HttpFoundation\Response;
use Carbon\Carbon;

class TokenExpirationMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        $token = $request->bearerToken();

        if (!$token) {
            return response()->json(['message' => 'Token not provided'], Response::HTTP_UNAUTHORIZED);
        }

        $accessToken = PersonalAccessToken::findToken($token);

        if (!$accessToken) {
            return response()->json(['message' => 'Invalid token'], Response::HTTP_UNAUTHORIZED);
        }

        // Check if the token is expired
        if ($accessToken->expires_at < Carbon::now()) {
            // Delete the expired token from the database
           // Permanently delete expired token
           PersonalAccessToken::where('id', $accessToken->id)->delete();

            return response()->json(['message' => 'Token expired'], Response::HTTP_UNAUTHORIZED);
        }

        return $next($request);
    }
}
