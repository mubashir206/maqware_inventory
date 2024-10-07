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
        Schema::create('item_usage_histories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('seller_user_id');
            $table->foreign('seller_user_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('item_id'); 
            $table->foreign('item_id')->references('id')->on('items')->onDelete('cascade');
            $table->unsignedBigInteger('restaurant_id'); 
            $table->foreign('restaurant_id')->references('id')->on('restaurants')->onDelete('cascade');
            $table->integer('quantity');
            $table->unsignedBigInteger('buyer_user_id');
            $table->foreign('buyer_user_id')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('item_usage_histories');
    }
};
