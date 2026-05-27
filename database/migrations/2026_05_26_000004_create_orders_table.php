<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('daily_menu_id')->constrained()->cascadeOnDelete();
            $table->foreignId('restaurant_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->unsignedInteger('quantity')->default(1);
            $table->decimal('total_price', 12, 2)->default(0);
            $table->string('status')->default('pending');
            $table->dateTime('ordered_at');
            $table->dateTime('delivered_at')->nullable();
            $table->text('note')->nullable();
            $table->timestamps();

            $table->index(['restaurant_id', 'status', 'ordered_at']);
            $table->index(['daily_menu_id', 'user_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};