<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['daily_menu_id', 'restaurant_id', 'user_id', 'quantity', 'total_price', 'status', 'ordered_at', 'delivered_at', 'note'])]
class Order extends Model
{
    use HasFactory;

    protected function casts(): array
    {
        return [
            'quantity' => 'integer',
            'total_price' => 'decimal:2',
            'ordered_at' => 'datetime',
            'delivered_at' => 'datetime',
        ];
    }

    public function dailyMenu(): BelongsTo
    {
        return $this->belongsTo(DailyMenu::class);
    }

    public function restaurant(): BelongsTo
    {
        return $this->belongsTo(Restaurant::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function markDelivered(): void
    {
        $this->fill([
            'status' => 'delivered',
            'delivered_at' => now(),
        ]);

        $this->save();
    }
}