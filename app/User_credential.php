<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class User_credential extends Model
{
    //
	public $timestamps = false;
	protected $fillable = ['function_name'];
	
    public function user_profile(){
    	return $this->belongsToMany('App\User_profile', 'profile_credentials', 'id_user_profile', 'id_user_credential');
    }
    
    
    public static function has_permision($function_name,$id){
    	//PROBAR!!! 3 casos, un usuario no admin sin un admin registrado, un usuario no con un admin registrado y un usuario admin con un admin registrado 
    	//DB::table('user_credentials')->where([['function_name',"=", $function_name],['id_user',"=",$id],["credential","=",true]])->orWhere([['credential',"=", "*"],['id_user',"=",$id]])->get();
    	    	
    	$return = DB::table('profile_credentials')->join('user_credentials','user_credentials.id','=','id_user_credential')
    									->where([['function_name',"=", $function_name],['id_user_profile',"=",$id],["credential","=",true]])
    									->orWhere([['function_name',"=", "*"],['id_user_profile',"=",$id]])->get();
    	return count($return)>0?true:false;
    }
    
    public static function getCredentials($profile_id){
    	return DB::table('profile_credentials')->join('user_credentials','user_credentials.id','=','id_user_credential')
    	->where([['id_user_profile',"=",$profile_id],["credential","=",true]])->get()->pluck("function_name")->toArray();
    }
    
}
