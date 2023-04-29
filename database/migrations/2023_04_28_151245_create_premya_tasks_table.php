<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePremyaTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('premya_tasks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('tg_user', 'id')->onDelete('CASCADE');
            $table->foreignId('premya_id')->constrained('premya', 'id')->onDelete('CASCADE');
            $table->integer('prodaja');
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
        Schema::dropIfExists('premya_tasks');
    }
}
