<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMcOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mc_orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pharmacy_id')->nullable();
            $table->foreignId('pro_pharmacy_id')->nullable();
            $table->foreignId('user_id')->nullable();
            $table->foreignId('employee_id');
            $table->foreignId('delivery_id')->nullable();
            $table->string('number')->nullable();
            $table->integer('price')->nullable();
            $table->integer('discount')->nullable();
            $table->integer('order_detail_status')->default(1);
            $table->integer('payment_status')->default(1);
            $table->timestamp('order_date');
            $table->integer('outer')->default(1);
            $table->integer('prepayment')->default(1);
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
        Schema::dropIfExists('mc_orders');
    }
}
