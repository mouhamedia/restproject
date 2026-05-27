<?php

namespace App\Http\Controllers;

use App\Models\DailyMenu;
use App\Models\Order;
use App\Models\Restaurant;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'daily_menu_id' => ['required', 'exists:daily_menus,id'],
            'quantity' => ['nullable', 'integer', 'min:1'],
            'note' => ['nullable', 'string', 'max:1000'],
        ]);

        $menu = DailyMenu::with('restaurant')->findOrFail($data['daily_menu_id']);

        abort_unless($menu->canAcceptOrders(), 403, 'Orders are closed for this menu.');

        $quantity = $data['quantity'] ?? 1;

        $order = Order::create([
            'daily_menu_id' => $menu->id,
            'restaurant_id' => $menu->restaurant_id,
            'user_id' => $request->user()->id,
            'quantity' => $quantity,
            'total_price' => ($menu->price ?? 1000) * $quantity,
            'status' => 'pending',
            'ordered_at' => now(),
            'note' => $data['note'] ?? null,
        ]);

        return response()->json([
            'message' => 'Order placed successfully.',
            'order' => $order,
        ], 201);
    }

    public function markDelivered(Order $order): JsonResponse
    {
        $order->markDelivered();

        return response()->json([
            'message' => 'Order marked as delivered.',
            'order' => $order->fresh(),
        ]);
    }

    public function summary(Restaurant $restaurant): JsonResponse
    {
        $todayOrders = $restaurant->orders()
            ->whereDate('ordered_at', now())
            ->with('dailyMenu')
            ->get();

        return response()->json([
            'restaurant' => $restaurant->only(['id', 'name', 'code']),
            'orders_count' => $todayOrders->count(),
            'total_quantity' => $todayOrders->sum('quantity'),
            'orders' => $todayOrders,
        ]);
    }
}