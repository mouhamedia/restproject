<?php

namespace App\Http\Controllers;

use App\Models\DailyMenu;
use App\Models\Order;
use App\Models\Restaurant;
use App\Models\Subscription;
use App\Models\User;
use Illuminate\View\View;

class DeveloperDashboardController extends Controller
{
    public function index(): View
    {
        $today = now();

        return view('developer.dashboard', [
            'stats' => [
                'users' => User::count(),
                'restaurants' => Restaurant::count(),
                'active_restaurants' => Restaurant::where('is_active', true)->count(),
                'subscriptions' => Subscription::count(),
                'active_subscriptions' => Subscription::where('status', 'active')
                    ->where('ends_at', '>=', $today)
                    ->count(),
                'menus_today' => DailyMenu::whereDate('menu_date', $today->toDateString())->count(),
                'orders' => Order::count(),
                'pending_orders' => Order::where('status', 'pending')->count(),
                'delivered_orders' => Order::where('status', 'delivered')->count(),
            ],
            'recentRestaurants' => Restaurant::with('owner:id,name,email')
                ->latest()
                ->limit(5)
                ->get(),
            'recentOrders' => Order::with([
                    'user:id,name,email',
                    'restaurant:id,name',
                    'dailyMenu:id,title,menu_date',
                ])
                ->latest('ordered_at')
                ->limit(5)
                ->get(),
        ]);
    }
}
