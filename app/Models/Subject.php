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
       
    ];

    public function schedules(){
        return $this->hasMany(Schedule::class);
    }

    public function teacher(){
        return $this->belongsToMany(Teacher::class);
    }


}
