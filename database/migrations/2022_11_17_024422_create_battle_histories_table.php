<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBattleHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tg_battle_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('win_user_id');
            $table->foreignId('lose_user_id');
            $table->date('start_day');
            $table->date('end_day');
            $table->integer('ball1');
            $table->integer('ball2');
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
        Schema::dropIfExists('battle_histories');
    }
}
