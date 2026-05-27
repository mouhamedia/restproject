<?php

namespace App\Http\Controllers;

use App\Models\Restaurant;
use App\Models\Subscription;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class SubscriptionController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'restaurant_id' => ['required', 'exists:restaurants,id'],
            'user_id' => ['required', 'exists:users,id'],
            'duration_days' => ['required', 'integer', 'min:1'],
            'amount_paid' => ['required', 'numeric', 'min:0'],
            'notes' => ['nullable', 'string', 'max:1000'],
        ]);

        $startedAt = Carbon::now();

        $subscription = Subscription::updateOrCreate(
            [
                'restaurant_id' => $data['restaurant_id'],
                'user_id' => $data['user_id'],
            ],
            [
                'started_at' => $startedAt,
                'ends_at' => $startedAt->copy()->addDays($data['duration_days']),
                'duration_days' => $data['duration_days'],
                'amount_paid' => $data['amount_paid'],
                'status' => 'active',
                'notes' => $data['notes'] ?? null,
            ]
        );

        return response()->json([
            'message' => 'Subscription saved successfully.',
            'subscription' => $subscription,
        ], 201);
    }

    public function renew(Request $request, Subscription $subscription): JsonResponse
    {
        $data = $request->validate([
            'duration_days' => ['required', 'integer', 'min:1'],
            'amount_paid' => ['required', 'numeric', 'min:0'],
        ]);

        $subscription->renew($data['duration_days'], (float) $data['amount_paid']);

        return response()->json([
            'message' => 'Subscription renewed successfully.',
            'subscription' => $subscription->fresh(),
        ]);
    }

    public function active(User $user, Restaurant $restaurant): JsonResponse
    {
        $subscription = Subscription::query()
            ->where('user_id', $user->id)
            ->where('restaurant_id', $restaurant->id)
            ->latest('ends_at')
            ->first();

        return response()->json([
            'subscription' => $subscription,
            'is_active' => $subscription?->isActive() ?? false,
        ]);
    }
}