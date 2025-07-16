<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\PersonalAccessToken;

class AuthController extends Controller
{
    public function login(Request $request): RedirectResponse | JsonResponse
    {
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        if (!Auth::attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        // /** @var \App\Models\User $user */
        $user = $request->user();

        $existingToken = $user->tokens()->where('name', 'api_token')->where('expires_at', '>', now())->first();

        if ($existingToken) {
            return response()->json([
                'message' => 'Token still valid',
                'expires_at' => $existingToken->expires_at,
            ]);
        }

        $token = $user->createToken('api_token', ['*'], now()->addDay());
        // $token = $user->createToken('api_token', ['*'], now()->addSeconds(20));

        return response()->json([
            'message' => 'Created new token successfully',
            'token' => $token->plainTextToken,
            'expires_at' => $token->accessToken->expires_at,
        ]);
    }

    public function register(Request $request): JsonResponse
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
        ]);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return response()->json([
            'message' => 'User registered successfully',
            'user'    => $user
        ]);
    }
}
