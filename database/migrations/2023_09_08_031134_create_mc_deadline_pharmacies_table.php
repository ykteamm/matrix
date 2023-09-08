<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMcDeadlinePharmaciesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mc_deadline_pharmacies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('region_id')->nullable();
            $table->foreignId('pharmacy_id')->nullable();
            $table->integer('day');
            $table->integer('discount')->default(0);
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
        Schema::dropIfExists('mc_deadline_pharmacies');
    }
}
