<?php

namespace App\Models;

 use App\Http\Traits\UserTrait;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable  implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable , UserTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function userProfile(){
        return $this->hasOne(UserProfile::class);
    }

    public function roles(){
        return $this->belongsToMany(Role::class);
    }

    public function isAdmin(){
        foreach($this->roles as $role){
            if($role->name == 'Admin'){
                return true;
            }

        }
        return false;
        // $user = auth()->user();

        // if ($user && $user->roles->contains('role', 'Admin')) {
        //     return true;
        // }
    
        // return false;
    }


    public function isTeacher(){
        foreach($this->roles as $role){
            if($role->name == 'Teacher'){
                return true;
            }

        }
        return false;
        // $user = auth()->user();

        // if ($user && $user->roles->contains('role', 'Admin')) {
        //     return true;
        // }
    
        // return false;
    }

    public function isStudent(){
        foreach($this->roles as $role){
            if($role->name == 'Student'){
                return true;
            }

        }
        return false;

    }

    public function status(){
        $pendingRequestsCount = \DB::table('pending_request')
            ->where('user_id', $this->id)
            ->count();

        if ($pendingRequestsCount > 0) {
            return 'pending';
        } else {
            return 'approved';
        }
    }


    public function teacher(){
        return $this->hasOne(Teacher::class);
    }
    public function student(){
        return $this->hasOne(Student::class);
    }
}
