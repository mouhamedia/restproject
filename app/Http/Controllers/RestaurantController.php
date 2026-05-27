<?php

namespace App\Http\Controllers;

use App\Models\Restaurant;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RestaurantController extends Controller
{
    public function show(Request $request): JsonResponse
    {
        $restaurant = $request->user()?->restaurant()->with(['menus', 'subscriptions', 'orders'])->first();

        return response()->json([
            'restaurant' => $restaurant,
        ]);
    }

    public function update(Request $request, Restaurant $restaurant): JsonResponse
    {
        $data = $request->validate([
            'name' => ['sometimes', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:1000'],
            'phone' => ['nullable', 'string', 'max:30'],
            'address' => ['nullable', 'string', 'max:255'],
            'is_active' => ['sometimes', 'boolean'],
        ]);

        $restaurant->update($data);

        return response()->json([
            'message' => 'Restaurant profile updated successfully.',
            'restaurant' => $restaurant->fresh(),
        ]);
    }
}