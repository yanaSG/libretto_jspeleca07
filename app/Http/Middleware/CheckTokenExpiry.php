<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckTokenExpiry
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->user() && $token = $request->user()->currentAccessToken()) {
            if ($token instanceof \Laravel\Sanctum\PersonalAccessToken) {
                if ($token->expires_at && $token->expires_at->isPast()) {
                    $token->delete();
                    return response()->json(['message' => 'Token expired'], 401);
                }
            }
        }

        return $next($request);
    }
}