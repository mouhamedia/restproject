<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

#[Fillable(['restaurant_id', 'user_id', 'amount_paid', 'started_at', 'ends_at', 'duration_days', 'status', 'notes'])]
class Subscription extends Model
{
    use HasFactory;

    protected function casts(): array
    {
        return [
            'amount_paid' => 'decimal:2',
            'started_at' => 'datetime',
            'ends_at' => 'datetime',
            'duration_days' => 'integer',
        ];
    }

    public function restaurant(): BelongsTo
    {
        return $this->belongsTo(Restaurant::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function isActive(): bool
    {
        return $this->status === 'active'
            && $this->ends_at !== null
            && $this->ends_at->isFuture();
    }

    public function renew(int $durationDays, float $amountPaid = 0): void
    {
        $startedAt = $this->ends_at?->isFuture()
            ? $this->ends_at
            : Carbon::now();

        $this->fill([
            'duration_days' => $durationDays,
            'amount_paid' => $amountPaid,
            'started_at' => $startedAt,
            'ends_at' => $startedAt->copy()->addDays($durationDays),
            'status' => 'active',
        ]);

        $this->save();
    }
}