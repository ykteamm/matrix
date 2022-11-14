<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAcceptsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tg_accepts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pharmacy_id');
            $table->foreignId('medicine_id');
            $table->integer('number')->nullable();
            $table->integer('price');
            $table->dateTime('date_time');
            $table->dateTime('date');
            $table->foreignId('created_by');
            $table->foreignId('updated_by');
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
        Schema::dropIfExists('tg_accepts');
    }
}
