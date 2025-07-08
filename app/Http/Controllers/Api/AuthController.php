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
    //
    public function login(Request $request): RedirectResponse | JsonResponse
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        if (!Auth::attempt($request->only('email', 'password'))) {
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Invalid credentials',
                ], 401);
            }

            return redirect()->back()->withErrors(['email' => 'Invalid credentials'])->withInput();
        }

        /** @var \App\Models\User $user */
        $user = Auth::user();
        $token = $user->createToken('api_token', ['*'], now()->addDay())->plainTextToken;

        // Store token in session for debugging
        session(['api-token' => $token]);

        // Force session regeneration for security
        $request->session()->regenerate();

        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'Login successful',
                'user'    => $user,
                'token'   => $token,
            ]);
        }

        return redirect('/books');
    }

    public function register(Request $request): RedirectResponse | JsonResponse
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

        $token = $user->createToken(
            'api_token',
            ['*'],
            now()->addDay()
        )->plainTextToken;

        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'User registered successfully',
                'user'    => $user,
                'token'   => $token,
            ], 201);
        }

        return redirect('/login');
    }

    public function logout(Request $request): RedirectResponse|JsonResponse
    {
        $user = $request->user();

        // Handle API token logout (Sanctum)
        if ($user && $user->currentAccessToken() instanceof PersonalAccessToken) {
            try {
                $user->currentAccessToken()->delete();
            } catch (\Exception $e) {
                report($e);
            }
        }

        // Handle web session logout
        $isWebAuth = Auth::getDefaultDriver() === 'web' || !$request->expectsJson();

        if ($isWebAuth && $user) {
            Auth::guard('web')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
        }

        // Handle response
        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'Logged out successfully'
            ]);
        }

        return redirect('/login');
    }
}
