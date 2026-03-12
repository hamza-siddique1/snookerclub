<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tournament_matches', function (Blueprint $table) {

            $table->id();

            $table->foreignId('tournament_id');

            $table->integer('round');              // 1,2,3
            $table->integer('match_number');       // bracket order

            $table->foreignId('player1_id')->nullable();
            $table->foreignId('player2_id')->nullable();

            $table->foreignId('winner_id')->nullable();

            $table->foreignId('next_match_id')->nullable();

            $table->integer('next_match_slot')->nullable(); // 1 or 2

            $table->string('status')->default('pending'); // pending, running, completed

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tournament_matches');
    }
};
