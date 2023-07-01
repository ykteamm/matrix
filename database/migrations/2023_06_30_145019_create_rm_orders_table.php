<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRmOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rm_orders', function (Blueprint $table) {
            $table->id();
            $table->string('number');
            $table->integer('status');
            $table->date('date');
            $table->integer('discount');
            $table->integer('summa');
            $table->integer('discount_summa');
            $table->foreignId('pharmacy_id')->nullable();
            $table->foreignId('user_id')->nullable();
            $table->integer('outer')->default(0);
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
        Schema::dropIfExists('rm_orders');
    }
}
