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
        Schema::create('snooker_matches', function (Blueprint $table) {
            $table->id();
            $table->uuid('match_uuid')->unique();
            $table->string('slug')->unique();

            // Player Information
            $table->foreignId('player_1_id')->nullable();
            $table->foreignId('player_2_id')->nullable();
            $table->string('player_1_name');
            $table->string('player_2_name');

            // Frame Information
            $table->integer('current_frame')->default(1);
            $table->integer('player_1_frames')->default(0);
            $table->integer('player_2_frames')->default(0);

            // Current Frame Scores
            $table->integer('player_1_points')->default(0);
            $table->integer('player_2_points')->default(0);
            $table->integer('player_1_break')->default(0);
            $table->integer('player_2_break')->default(0);

            // Playing Status
            $table->string('current_player')->default('player_1'); // who is currently playing
            $table->enum('status', ['setup', 'playing', 'paused', 'completed'])->default('setup');

            // Match History (JSON for action tracking)
            $table->json('actions_history')->nullable();

            // Table Information
            $table->string('table_name')->nullable();
            $table->string('table_number')->nullable();

            // Timestamps
            $table->timestamp('started_at')->nullable();
            $table->timestamp('ended_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('snooker_matches');
    }
};
