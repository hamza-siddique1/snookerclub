<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTournamentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tournaments', function (Blueprint $table) {
            $table->id();
            $table->integer('player_1');
            $table->integer('player_2');
            $table->timestamp('year')->nullable();
            $table->text('tournament')->nullable();
            $table->text('rules')->nullable();
            $table->text('round')->nullable();
            $table->integer('winner')->nullable();
            $table->integer('score_player_1')->nullable();
            $table->integer('score_player_2')->nullable();
            $table->text('result')->nullable();
            $table->text('type')->nullable();
            $table->text('draw_url')->nullable();
            $table->text('table')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tournaments');
    }
}
