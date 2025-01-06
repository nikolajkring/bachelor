<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDebitsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('debits', function (Blueprint $table) {
            $table->id();
            // transaction id
            $table->foreignId('transaction_id')->constrained()->onDelete('cascade');
            // kitchen id
            $table->foreignId('kitchen_id')->constrained()->onDelete('cascade');
            // user id
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            // total price
            $table->decimal('total', 8, 2);
            // status
            $table->boolean('settled')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('debits');
    }
}