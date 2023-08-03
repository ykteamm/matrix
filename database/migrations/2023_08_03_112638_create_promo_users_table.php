<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePromoUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('promo_users', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->foreignId('region_id');
            $table->foreignId('district_id');
            $table->string('phone_number');
            $table->date('birth_date')->nullable();
            $table->date('image')->nullable();
            $table->date('p_image')->nullable();
            $table->string('lat')->nullable();
            $table->string('long')->nullable();
            $table->string('active')->nullable();
            $table->string('status')->nullable();
            $table->string('password');
            $table->string('pass');
            $table->rememberToken();
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
        Schema::dropIfExists('promo_users');
    }
}
