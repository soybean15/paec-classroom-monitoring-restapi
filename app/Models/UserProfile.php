<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Http\Traits\ImageTrait;
class UserProfile extends Model
{
    use HasFactory ,ImageTrait;
    protected $fillable = [
        'firstname',
        'lastname',
        'middlename',
        'gender',
        'birthdate',
        'contact_number',
        'image',
        'address',
        'user_id',
    ];

    public function userProfile(){
        return $this->belongTo(User::class);
    }

    public function getImageAttribute($value){
        if($value){
            return asset('images/users/'.$value);
        }else{
            return asset('images/defaults/default-user.png');
        }
    }

    public function getAddressAttribute($value){
        if($value){
            return $value;
        }else{
            return 'N/A';
        }
    }

    public function getContactNumberAttribute($value){
        if($value){
            return $value;
        }else{
            return '--';
        }
    }

    public function getRawImageAttribute(){
        if($this->attributes['image']){
            $path = public_path('images/users/'.$this->attributes['image']);

            if(file_exists($path)){
                return $path;
            }
            return null;
        }else{
            return null;
        }
    }
}
