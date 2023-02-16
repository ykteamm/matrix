<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTeamBattlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tg_team_battles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('team1_id');
            $table->foreignId('team2_id');
            $table->date('month');
            $table->integer('round');
            $table->foreignId('win')->nullable();
            $table->foreignId('lose')->nullable();
            $table->date('start_day');
            $table->date('end_day');
            $table->json('team1_user')->nullable();
            $table->json('team2_user')->nullable();
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
        Schema::dropIfExists('tg_team_battles');
    }
}
