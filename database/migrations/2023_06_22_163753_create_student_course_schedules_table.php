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
        Schema::create('student_subject_schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_record_id')->constrained('student_records');
            $table->foreignId('subject_id')->constrained('subjects');
            $table->foreignId('teacher_id')->constrained('teachers');
     
            $table->timestamps();
            
            // Define foreign key constraints
   
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_subject_schedules');
    }
};
