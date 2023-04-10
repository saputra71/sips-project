<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use Illuminate\Http\Request;
use App\Helpers\ResponseFormatter;
use Laravel\Fortify\Rules\Password;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function register(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'username' => 'required|string|max:255|unique:users',
                'email' => 'required|string|email|max:255|unique:users',
                'phone_number' => 'nullable|string|unique:users',
                'password' => 'required|string|', new Password,
            ]);

            User::create([
                'name' => $request->name,
                'username' => $request->username,
                'email' => $request->email,
                'phone_number' => $request->phone_number,
                'password' => Hash::make($request->password),
            ]);

            $user = User::where('email', $request->email)->first();

            $token = $user->createToken('authToken')->plainTextToken;

            return ResponseFormatter::success([
                'access_token' => $token,
                'token_type' => 'Bearer',
                'user' => $user,
            ], 'User registered successfully');
        } catch (\Exception $e) {
            return ResponseFormatter::error([
                'message' => 'Something went wrong',
                'error' => $e
            ], 'Registration failed', 500);
        }
    }

    public function login(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'password' => 'required|string',
            ]);
            $user = User::where('name', $request->name)->first();
            if (!$user) {
                return ResponseFormatter::error([
                    'message' => 'User not found'
                ], 'Login failed', 404);
            }
            if (!Hash::check($request->password, $user->password)) {
                return ResponseFormatter::error([
                    'message' => 'Password is incorrect'
                ], 'Login failed', 401);
            }
            $token = $user->createToken('authToken')->plainTextToken;
            return ResponseFormatter::success([
                'access_token' => $token,
                'token_type' => 'Bearer',
                'user' => $user,
            ], 'User logged in successfully');
        } catch (\Exception $e) {
            return ResponseFormatter::error([
                'message' => 'Something went wrong',
                'error' => $e
            ], 'Login failed', 500);
        }
    }

    public function fetch(Request $request)
    {
        return ResponseFormatter::success([
            'user' => $request->user()
        ], 'User fetched successfully');
    }

    public function updateProfile(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'phone_number' => 'nullable|string',
        ]);

        $user = Auth::user();
        $user->update($validatedData);

        return ResponseFormatter::success([
            'user' => $user
        ], 'User updated successfully');
    }

    public function logout(Request $request)
    {
        $token = $request->user()->currentAccessToken()->delete();

        return ResponseFormatter::success($token, 'User logged out successfully');
    }
}
