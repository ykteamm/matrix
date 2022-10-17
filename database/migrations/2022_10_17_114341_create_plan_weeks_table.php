<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlanweeksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tg_planweeks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('plan_id');
            $table->integer('user_id');
            $table->foreignId('calendar_id');
            $table->integer('workday');
            $table->integer('plan');
            $table->date('startday');
            $table->date('endday');
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
        Schema::dropIfExists('tg_planweeks');
    }
}