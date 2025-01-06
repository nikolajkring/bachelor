<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            // Item id
            $table->foreignId('item_id')->constrained()->onDelete('cascade');
            // Kitchen id
            $table->foreignId('kitchen_id')->constrained()->onDelete('cascade');
            // User id
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            // Get price from item
            $table->decimal('price', 8, 2);
            // Get amount from item
            $table->integer('amount');
            // Total price = price * amount
            $table->decimal('total', 8, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
