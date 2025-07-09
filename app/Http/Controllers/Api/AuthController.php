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

        // For API requests, create and return token
        if ($request->expectsJson()) {
            $token = $user->createToken('api_token', ['*'], now()->addDay())->plainTextToken;

            return response()->json([
                'message' => 'Login successful',
                'user'    => $user,
                'token'   => $token,
            ]);
        }

        // For web requests, handle session
        $request->session()->regenerate();

        return redirect()->intended('/books');
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

        // For API requests, create and return token
        if ($request->expectsJson()) {
            $token = $user->createToken('api_token', ['*'], now()->addDay())->plainTextToken;

            return response()->json([
                'message' => 'User registered successfully',
                'user'    => $user,
                'token'   => $token,
            ], 201);
        }

        // For web requests, authenticate and redirect
        Auth::login($user);
        $request->session()->regenerate();

        return redirect('/books');
    }

    public function logout(Request $request): RedirectResponse|JsonResponse
    {
        /** @var \App\Models\User|null $user */
        $user = $request->user();

        try {
            // Handle API token logout (Sanctum)
            if ($user && method_exists($user, 'currentAccessToken')) {
                $token = $user->currentAccessToken();
                if ($token instanceof PersonalAccessToken) {
                    $token->delete();
                }
            }

            // Handle web session logout
            Auth::guard('web')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
        } catch (\Exception $e) {
            report($e);

            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Error during logout',
                    'error' => $e->getMessage()
                ], 500);
            }

            return redirect('/login')->withErrors(['logout' => 'Error during logout']);
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
