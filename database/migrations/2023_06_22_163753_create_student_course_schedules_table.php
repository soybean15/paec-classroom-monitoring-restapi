<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('student_schedules', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('student_id');
            $table->unsignedBigInteger('sy_id');
            $table->unsignedBigInteger('schedule_id');
            $table->string('section');
            $table->timestamps();
            
            // Define foreign key constraints
            $table->foreign('student_id')->references('id')->on('students');
            $table->foreign('sy_id')->references('id')->on('school_years');
            $table->foreign('schedule_id')->references('id')->on('schedules');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_course_schedules');
    }
};
