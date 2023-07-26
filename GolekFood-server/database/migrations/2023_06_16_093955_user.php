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
        Schema::create('users', function (Blueprint $table) {

            // name
            // email
            // password
            // address
            // avatar
            // roles id
            
            $table->id();
            $table->string('email')->unique();
            $table->string('google_id')->nullable();
            $table->string('facebook_id')->nullable();
            $table->string('name');
            $table->string('address')->nullable();
            $table->string('avatar')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('already_survey')->default('0');
            $table->string('password');
            $table->foreignId('roles_id')->constrained('roles');
            $table->rememberToken();
            // $table->string('subscription');
            // $table->timestamp('subscription_start')->nullable();
            // $table->timestamp('subscription_end')->nullable();   
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
