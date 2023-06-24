<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    use HasFactory;

    public function schedules(){
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

    public function subjects(){
        return $this->belongsToMany(Subject::class);
    }
}
