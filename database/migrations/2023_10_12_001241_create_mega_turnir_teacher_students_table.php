<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMegaTurnirTeacherStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mega_turnir_teacher_students', function (Blueprint $table) {
            $table->id();
            $table->foreignId('teacher_id');
            $table->foreignId('shogird_id');
            $table->integer('game')->default(1);
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
        Schema::dropIfExists('mega_turnir_teacher_students');
    }
}
