<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['restaurant_id', 'title', 'description', 'menu_date', 'order_deadline_at', 'price', 'estimated_servings', 'status', 'published_at'])]
class DailyMenu extends Model
{
    use HasFactory;

    protected function casts(): array
    {
        return [
            'menu_date' => 'date',
            'order_deadline_at' => 'datetime',
            'published_at' => 'datetime',
            'price' => 'decimal:2',
            'estimated_servings' => 'integer',
        ];
    }

    public function restaurant(): BelongsTo
    {
        return $this->belongsTo(Restaurant::class);
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function canAcceptOrders(): bool
    {
        return $this->status === 'published'
            && ($this->order_deadline_at === null || $this->order_deadline_at->isFuture());
    }
}