<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
       
    ];


    protected $appends = ['image'];

    public function getImageAttribute(){
        return "https://source.unsplash.com/random/250x150/?college&{$this->id}";
    }





}
