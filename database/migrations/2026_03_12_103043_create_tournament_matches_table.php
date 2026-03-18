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

            $table->foreignId('tournament_id')->nullable();

            $table->string('round')->nullable();              // 1,2,3
            $table->integer('match_number')->nullable();


            $table->foreignId('player1_id')->nullable();
            $table->foreignId('player2_id')->nullable();

            $table->foreignId('winner_id')->nullable();

            $table->foreignId('next_match_id')->nullable();

            $table->integer('next_match_slot')->nullable(); // 1 or 2

            $table->integer('score_player_1')->nullable();
            $table->integer('score_player_2')->nullable();
            $table->integer('break_run_player_1')->nullable();
            $table->integer('break_run_player_2')->nullable();

            $table->string('status')->default('pending'); // pending, running, completed

            $table->string('table')->default('1');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tournament_matches');
    }
};
