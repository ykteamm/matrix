<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKnowledgeGradesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tg_knowledge_grades', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->foreignId('teacher_id');
            $table->foreignId('pill_id')->nullable();
            $table->foreignId('knowledge_question_id')->nullable();
            $table->integer('grade');
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
        Schema::dropIfExists('knowledge_grades');
    }
}
