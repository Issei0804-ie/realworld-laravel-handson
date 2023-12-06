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
        Schema::create('follows', function (Blueprint $table) {
            $table->foreignId('follow_user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('follower_user_id')->constrained('users')->cascadeOnDelete();
            $table->timestamps();
            $table->unique(['follow_user_id', 'follower_user_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('follows');
    }
};
