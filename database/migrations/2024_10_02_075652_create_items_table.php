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
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->string('name'); 
            $table->string('description'); 
            $table->integer('quantity')->default(0); 
            $table->string('image')->nullable(); 
            $table->unsignedBigInteger('item_type_id');
            $table->foreign('item_type_id')->references('id')->on('item_types')->onDelete('cascade'); 
            $table->unsignedBigInteger('restaurant_id'); 
            $table->foreign('restaurant_id')->references('id')->on('restaurants')->onDelete('cascade');
            $table->unsignedBigInteger('user_id')->nullable(); 
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
