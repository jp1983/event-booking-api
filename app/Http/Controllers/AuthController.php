<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    
    /**
     * Register a new user and generate API token.
     */
    public function register(Request $request) {
        $validated = $request->validate([
            'username' => 'required|string|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6',
        ]);

        $user = User::create($validated);
        $token = $user->createToken('API Token')->accessToken;

        return response()->json(['message' => 'User registered', 'token' => $token], 201);
    }

    /**
     * Login and generate API token.
     */
    public function login(Request $request) {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if (!Auth::attempt($credentials)) {
            return response()->json(['error' => 'Invalid credentials'], 401);
        }

        $user = Auth::user();
        $token = $user->createToken('API Token')->accessToken;

        return response()->json(['message' => 'Login successful', 'token' => $token], 200);
    }


    /**
     * Logout user by revoking token.
     */
    public function logout(Request $request) {
        if (Auth::user()) {
            Auth::user()->token()->revoke();
            return response()->json(['message' => 'Logged out successfully'], 200);
        }

        return response()->json(['error' => 'Invalid request'], 400);
    }

}