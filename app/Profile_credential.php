<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Profile_credential extends Model
{
    //
	public $timestamps = false;
	protected $fillable = ['id_user_profile', 'id_user_credential', "credential"];
}
