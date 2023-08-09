<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMcOrderReturnsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mc_order_returns', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id');
            $table->foreignId('product_id');
            $table->foreignId('warehouse_id');
            $table->integer('quantity');
            $table->integer('price');
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
        Schema::dropIfExists('mc_order_returns');
    }
}
