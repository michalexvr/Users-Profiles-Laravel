<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class User_profile extends Model
{
    //
    public $timestamps = false;
    protected $fillable = ['profile_name', 'profile_description'];
    
	public function user_credentials(){
		return $this->belongsToMany('App\User_credential','profile_credentials','id_user_profile','id_user_credential')
		->withPivot('id');
	}

}
