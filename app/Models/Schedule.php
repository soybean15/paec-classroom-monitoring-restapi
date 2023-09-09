<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'start',
        'end',
        'day',
        'room_id',
        'section',
        'subject_teacher_id'
    ];



    public function getDayAttribute($value)
    {
       
        switch ($value) {
            case 1:
                return "Monday";
            case 2:
                return "Tuesday";
            case 3:
                return "Wednesday";
            case 4:
                return "Thursday";
            case 5:
                return "Friday";
            case 6:
                return "Saturday";
            default:
                return $value;

        }
    }


    public function room(){
        return $this->belongsTo(Room::class);
    }

    public function classes($subject_teacher_id){
        return $this->where('subject_teacer_id', $subject_teacher_id)->get();


    }



}