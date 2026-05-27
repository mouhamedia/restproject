<?php

namespace App\Http\Controllers;

use App\Models\DailyMenu;
use App\Models\Restaurant;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class DailyMenuController extends Controller
{
    public function index(Restaurant $restaurant): JsonResponse
    {
        return response()->json([
            'menus' => $restaurant->menus()->latest('menu_date')->get(),
        ]);
    }

    public function store(Request $request, Restaurant $restaurant): JsonResponse
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:2000'],
            'menu_date' => ['required', 'date'],
            'order_deadline_at' => ['nullable', 'date'],
            'price' => ['nullable', 'numeric', 'min:0'],
            'estimated_servings' => ['nullable', 'integer', 'min:0'],
        ]);

        $menu = $restaurant->menus()->create([
            'title' => $data['title'],
            'description' => $data['description'] ?? null,
            'menu_date' => $data['menu_date'],
            'order_deadline_at' => $data['order_deadline_at'] ?? Carbon::parse($data['menu_date'])->setTime(10, 30),
            'price' => $data['price'] ?? 1000,
            'estimated_servings' => $data['estimated_servings'] ?? null,
            'status' => 'published',
            'published_at' => now(),
        ]);

        return response()->json([
            'message' => 'Daily menu published successfully.',
            'menu' => $menu,
        ], 201);
    }

    public function today(Restaurant $restaurant): JsonResponse
    {
        $menu = $restaurant->menus()
            ->whereDate('menu_date', now())
            ->latest('published_at')
            ->first();

        return response()->json([
            'menu' => $menu,
            'can_accept_orders' => $menu?->canAcceptOrders() ?? false,
        ]);
    }
}