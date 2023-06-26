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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('school_year_id')->constrained('school_years');
            $table->integer('semester');
            $table->integer('school_year_start');
            $table->timestamps();
        });


        $semester = 1;
        $currentYear = date('Y');
        $nextYear = $currentYear + 1;
        $startOfSchoolYear = 6;
        $currentMonth = date('n');

        // Check if the current month is June (6) or later
        if ($currentMonth >= $startOfSchoolYear) {
            $startYear = $currentYear;
            $endYear = $nextYear;

        } else {
            $startYear = $currentYear - 1;
            $endYear = $currentYear;

            $semester = 2;
        }

        // Format the school year string
        $schoolYear = $startYear . '-' . $endYear;

        $_schoolYear = \App\Models\SchoolYear::create([
            'school_year'=>$schoolYear
        ]);


        \DB::table('settings')->insert( [
            'school_year_id' => $_schoolYear->id,
            'semester'=>$semester,
            'school_year_start'=>$startOfSchoolYear
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
