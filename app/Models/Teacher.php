<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    use HasFactory;




    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }

    public function sections()
    {
        return $this->hasManyThrough(Section::class, Schedule::class);
    }
    public function students()
    {
        return $this->hasManyThrough(Student::class, Schedule::class);
    }

    public function subjects()
    {
        return $this->belongsToMany(Subject::class);

    }

    public function availableSubjects( $schoolYearId, $semester)
    {
        $teacherId = $this->id;
        return \DB::table('subjects')
            ->leftJoin('subject_teacher', function ($join) use ($teacherId, $semester, $schoolYearId) {
                $join->on('subject_teacher.subject_id', '=', 'subjects.id')
                    ->where('subject_teacher.semester', '=', $semester)
                    ->where('subject_teacher.school_year_id', '=', $schoolYearId)
                    ->where('subject_teacher.teacher_id', '=', $teacherId);
            })
            ->select('subjects.*')
            ->whereNull('subject_teacher.subject_id');
            
      
    }





    public function scopeCurrentSubjects($query): void
    {
        $query->where('votes', '>', 100);
    }



}