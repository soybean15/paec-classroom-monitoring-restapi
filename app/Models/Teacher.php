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
        $setting = \DB::table('settings')->get();

        return \DB::table('schedules')
        ->join('subject_teacher', 'schedules.subject_teacher_id', '=', 'subject_teacher.id')
        ->select('schedules.*')
        ->where('subject_teacher.teacher_id', $this->user_id)
        ->where('subject_teacher.semester', 1)
        ->where('subject_teacher.school_year_id', 1)
        ;
    
   

    }


    public function hasConflictingTime($start, $end, $day)
    {

        return $this->schedules()
            ->where('day', $day)
            ->where(function ($query) use ($start, $end, $day) {
                $query->where(function ($innerQuery) use ($start, $end, $day) {
                    $innerQuery->where('day', $day)
                        ->where('start', '<', $end)
                        ->where('end', '>', $start);
                })->orWhere(function ($innerQuery) use ($start, $end, $day) {
                    $innerQuery->where('day', $day)
                        ->where('start', '<=', $start)
                        ->where('end', '>=', $end);
                });
            })
            ->exists();



    }


    public function students()
    {
        return $this->hasManyThrough(Student::class, Schedule::class);
    }

    public function subjects()
    {
        return $this->belongsToMany(Subject::class);

    }

    public function availableSubjects($schoolYearId, $semester)
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

    public function teacherSubjects($schoolYearId, $semester)
    {
        $teacherId = $this->user_id;


        return \DB::table('subjects')
            ->join('subject_teacher', function ($join) use ($teacherId, $semester, $schoolYearId) {
                $join->on('subject_teacher.subject_id', '=', 'subjects.id')
                    ->where('subject_teacher.semester', '=', $semester)
                    ->where('subject_teacher.school_year_id', '=', $schoolYearId)
                    ->where('subject_teacher.teacher_id', '=', $teacherId);
            })
            ->join('courses', 'courses.id', '=', 'subjects.id')
            ->select('subjects.*', 'subject_teacher.id as pivot_id', 'courses.name as course_name');
    }






    public function scopeCurrentSubjects($query): void
    {
        $query->where('votes', '>', 100);
    }



}