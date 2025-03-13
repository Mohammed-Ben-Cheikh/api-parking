<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Traits\HttpResponses;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\StoreUserRequest;

class AuthController extends Controller
{
    use HttpResponses;


    public function login(LoginUserRequest $request)
    {
        // Validate request
        $validated = $request->validated();

        // Attempt authentication
        if (!Auth::attempt($validated)) {
            return $this->error(null, 'Invalid credentials', 401);
        }

        // Retrieve authenticated user
        $user = Auth::user();

        return $this->success([
            'user'  => $user,
            'token' => $user->createToken('API Token')->plainTextToken
        ], 'Login successful');
    }


    public function register(StoreUserRequest $request)
    {
        try {
            // Validate request
            $validated = $request->validated();

            // Create new user
            $user = User::create([
                'name'     => $validated['name'],
                'email'    => $validated['email'],
                'password' => Hash::make($validated['password']),
            ]);

            return $this->success([
                'user'  => $user,
                'token' => $user->createToken('API Token')->plainTextToken
            ], 'User registered successfully', 201);
        } catch (\Exception $e) {
            return $this->error(null, 'User registration failed: ' . $e->getMessage(), 500);
        }
    }


    public function logout(Request $request)
    {
        try {
            $request->user()->currentAccessToken()->delete();
            return $this->success(null, 'Successfully logged out');
        } catch (\Exception $e) {
            return $this->error(null, 'Logout failed: ' . $e->getMessage(), 500);
        }
    }
}
