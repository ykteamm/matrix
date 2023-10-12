<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMegaTurnirTeamBattlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mega_turnir_team_battles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user1id');
            $table->foreignId('user2id');
            $table->integer('tour');
            $table->integer('win')->nullable();
            $table->integer('lose')->nullable();
            $table->integer('sold1')->default(0);
            $table->integer('sold2')->default(0);
            $table->date('begin');
            $table->date('end');
            $table->integer('ends')->default(0);
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
        Schema::dropIfExists('mega_turnir_team_battles');
    }
}
