<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePromoOrderProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('promo_order_products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->onDelete('CASCADE');
            $table->foreignId('product_id')->onDelete('CASCADE');
            $table->integer('quantity');
            $table->integer('product_price');
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
        Schema::dropIfExists('promo_order_products');
    }
}
