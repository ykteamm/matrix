<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePatientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('patients', function (Blueprint $table) {
            $table->id();
            $table->string('pinfl');
            $table->foreignId('hospital_id')->nullable();
            $table->foreignId('branch_id')->nullable();
            $table->string('passport');
            $table->string('last_name');
            $table->string('first_name');
            $table->string('full_name');
            $table->string('phone');
            $table->date('birth_day');
            $table->integer('age');
            $table->foreignId('province_id');
            $table->foreignId('district_id');
            $table->double('height',8,2);
            $table->integer('weight');
            $table->double('bmi',8,2);
            $table->double('temp',8,2);
            $table->boolean('gender');
            $table->integer('case_number');
            $table->timestamp('case_date');
            $table->boolean('admission');
            $table->json('diagnos')->nullable();
            $table->json('illness')->nullable();
            $table->json('patient_exam')->nullable();
            $table->foreignId('ekg_id')->nullable();
            $table->foreignId('exo_id')->nullable();
            $table->json('treatment')->nullable();
            $table->boolean('death')->nullable();
            $table->string('treatment_tip')->nullable();
            $table->integer('patient_back')->nullable();
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
        Schema::dropIfExists('patients');
    }
}
