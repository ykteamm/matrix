<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMegaTurnirTeachersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mega_turnir_teachers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('teacher_id');
            $table->string('group_name')->nullable();
            $table->integer('teacher_or_stajer')->default(0);
            $table->integer('teacher_or_rm')->default(0);
            $table->integer('plan')->default(0);
            $table->date('month')->nullable();
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
        Schema::dropIfExists('mega_turnir_teachers');
    }
}
