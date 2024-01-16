<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNewOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('new_orders', function (Blueprint $table) {
            $table->id();
            $table->string('number');
            $table->integer('summa');
            $table->integer('pay_summa')->default(0);
            $table->integer('discount');
            $table->integer('discount_summa');
            $table->date('date');
            $table->foreignId('region_id')->nullable();
            $table->foreignId('pharmacy_id')->nullable();
            $table->foreignId('user_id')->nullable();
            $table->foreignId('delivery_id')->nullable();
            $table->integer('status')->default(0); // 0-yangi 1-qarzdor 2-yakunlangan
            $table->integer('outer')->default(0); // 1-tashqi 0-tashqi emas;
            $table->integer('prepay')->default(0); // 1-predoplata 0-predoplata emas
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
        Schema::dropIfExists('new_orders');
    }
}
