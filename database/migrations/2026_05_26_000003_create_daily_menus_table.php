<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('daily_menus', function (Blueprint $table) {
            $table->id();
            $table->foreignId('restaurant_id')->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->text('description')->nullable();
            $table->date('menu_date');
            $table->dateTime('order_deadline_at')->nullable();
            $table->decimal('price', 12, 2)->default(1000);
            $table->unsignedInteger('estimated_servings')->nullable();
            $table->string('status')->default('published');
            $table->dateTime('published_at')->nullable();
            $table->timestamps();

            $table->unique(['restaurant_id', 'menu_date']);
            $table->index(['restaurant_id', 'status', 'order_deadline_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('daily_menus');
    }
};