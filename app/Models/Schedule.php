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




}
