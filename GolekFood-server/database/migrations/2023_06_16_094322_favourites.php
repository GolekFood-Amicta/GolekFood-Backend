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
        Schema::create('favourites', function (Blueprint $table) {
            // user_id
            // foodname
            // fat
            // protein
            // carbohydrate
            // calories
            // image
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->string('food_id');
            $table->string('foodname');
            $table->string('fat');
            $table->string('protein');
            $table->string('carbohydrate');
            $table->string('calories');
            $table->string('image')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('favourites');
    }
};
