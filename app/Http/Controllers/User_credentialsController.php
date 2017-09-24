<?php

namespace App\Http\Controllers;

use App\User_credential;
use Illuminate\Support\Facades\Auth;


class User_credentialsController extends Controller
{
    /*
     * Tipos de permisos posibles:
     * 
     * 1: Admin: * (* significa todo, tiene acceso a todo) 
     * 2: cualquier otro usuario, la lista según la ruta solicitada.
     * */
    public static function has_permision($function_name){
    	$user = Auth::user();
    	
    	$function_name = preg_replace('/[0-9]+/', '{i}', $function_name);
    	return User_credential::has_permision($function_name,$user->user_profile_id)?true:false;
    }
    
    public static function getCredentials(){
    	$user = Auth::user();
    	return User_credential::getCredentials($user->user_profile_id);
    }
    
    
}
