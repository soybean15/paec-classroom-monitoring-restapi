<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'unit',
        'year_level',
        'semester',
        'course_id'

    ];

    //protected $attributes = ['image','course_name'];
    protected $appends = ['course_name', 'image'];

    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }

    public function teacher()
    {
        return $this->belongsToMany(Teacher::class);
    }

    public function schoolYear()
    {
        return $this->belongsTo(SchoolYear::class);
    }

    public function course()
    {

        return $this->belongsTo(Course::class);
    }

    public function getCourseNameAttribute()
    {
        // Check if the course relationship is loaded
        if ($this->relationLoaded('course')) {
            return $this->course ? $this->course->name : 'General Education';
        }

        // If the course relationship is not loaded, fetch it from the database
        $course = $this->course()->first(['name']);

        return $course ? $course->name : 'General Education';
    }

    public function getYearLevelAttribute($value)
    {

        switch ($value) {
            case 1:
                return "{$value}st";
            case 2:
                return "{$value}nd";
            case 3:
                return "{$value}rd";
            default:
                return "{$value}th";
        }


    }

    public function getSemesterAttribute($value)
    {

        switch ($value) {
            case 1:
                return "{$value}st";
            case 2:
                return "{$value}nd";
            default:
                return "{$value}th";

        }

    }

    public function getImageAttribute()
    {
        return "https://source.unsplash.com/random/250x150/?books&{$this->id}";

    }

    public function scopeSubjectByCourse($query, $courseId)
    {

        return $query->where(function ($query) use ($courseId) {
            $query->where('course_id', $courseId)
                ->orWhereNull('course_id');
        });
    }


}