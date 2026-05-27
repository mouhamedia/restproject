<?php

namespace App\Http\Controllers;

use App\Models\Restaurant;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class AuthController extends Controller
{
    public function registerRestaurant(Request $request): JsonResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'restaurant_name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:1000'],
            'phone' => ['nullable', 'string', 'max:30'],
            'address' => ['nullable', 'string', 'max:255'],
        ]);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $data['password'],
            'role' => 'restaurant',
        ]);

        $restaurant = Restaurant::create([
            'owner_user_id' => $user->id,
            'name' => $data['restaurant_name'],
            'description' => $data['description'] ?? null,
            'phone' => $data['phone'] ?? null,
            'address' => $data['address'] ?? null,
            'is_active' => true,
        ]);

        Auth::login($user);

        return response()->json([
            'message' => 'Restaurant account created successfully.',
            'user' => $user,
            'restaurant' => $restaurant,
        ], 201);
    }

    public function registerClient(Request $request): JsonResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'restaurant_code' => ['required', 'string', 'exists:restaurants,code'],
        ]);

        $restaurant = Restaurant::where('code', $data['restaurant_code'])->firstOrFail();

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $data['password'],
            'role' => 'client',
        ]);

        Auth::login($user);

        return response()->json([
            'message' => 'Client account created successfully.',
            'user' => $user,
            'restaurant' => $restaurant,
        ], 201);
    }

    public function login(Request $request): JsonResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
            'role' => ['nullable', Rule::in(['restaurant', 'client', 'developer'])],
        ]);

        $attempt = Arr::only($credentials, ['email', 'password']);

        if (! Auth::attempt($attempt, $request->boolean('remember'))) {
            return response()->json([
                'message' => 'Invalid credentials.',
            ], 422);
        }

        $request->session()->regenerate();

        $user = $request->user();

        if (isset($credentials['role']) && $user?->role !== $credentials['role']) {
            Auth::logout();

            return response()->json([
                'message' => 'This account does not match the requested role.',
            ], 403);
        }

        return response()->json([
            'message' => 'Logged in successfully.',
            'user' => $user,
        ]);
    }

    public function logout(Request $request): JsonResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return response()->json([
            'message' => 'Logged out successfully.',
        ]);
    }
}