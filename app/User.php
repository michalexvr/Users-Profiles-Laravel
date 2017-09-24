<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','user_profile_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    
    public function User_credentials() {
    	return $this->hasMany('App\User_credential', 'id_user', 'id');
    }
    
    public function user_profile_image(){
    	return $this->hasOne('App\User_profile_image', 'user_id', 'id');
    }
}
