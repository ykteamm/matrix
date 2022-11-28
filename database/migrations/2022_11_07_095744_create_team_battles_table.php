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
            $table->date('begin');
            $table->date('end')->nullable();
            $table->boolean('ended')->default(false);
            $table->integer('win_id')->nullable();
            $table->integer('lose_id')->nullable();
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
