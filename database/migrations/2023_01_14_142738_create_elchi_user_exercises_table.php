<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateElchiUserExercisesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tg_elchi_user_exercise', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->foreignId('medicine_id');
            $table->integer('number');
            $table->integer('elexir');
            $table->double('ball',8,2);
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
        Schema::dropIfExists('elchi_user_exercises');
    }
}
