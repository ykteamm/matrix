<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCrystalUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('crystal_users', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->integer('crystal')->dafault(0);
            $table->longText('comment')->nullable();
            $table->integer('active')->dafault(1);
            $table->date('add_date')->nullable();
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
        Schema::dropIfExists('crystal_users');
    }
}
