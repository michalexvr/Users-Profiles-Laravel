<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User_profile;
use Illuminate\Support\Facades\Route;
use App\User_credential;
use App\Profile_credential;
use App\User;

class User_profilesController extends Controller
{
    //
	public function getList($message = null){
		$profiles = User_profile::All();
		
		return view("users.profile-list",Array("profiles"=>$profiles, "message"=>$message));
	}
	
	public function addProfile($message = null){
		$credentials = $this->getCredentials();		
		return view("users.profile-add",Array("credentials"=>$credentials));
	}
	
	public function getCredentials(){
		$routeCollection = Route::getRoutes();
		$credentials = Array();
		
		$last="";
		foreach ($routeCollection as $value) {
			if($last != $value->uri) {
				//$name = isset($value->getName())?$value->getName():"NN";
				
				if(in_array("has_access",$value->Middleware()) && strlen($value->getName())>0){
					$credentials[] = Array("uri"=>$value->uri,"name"=>$value->getName());
					//echo $value->uri." -> ".$value->getName()."<br>";
					$last = $value->uri;
				}
			}
		}
		return $credentials;
	}
	
	public function insertProfile(Request $request){
			//se inserta la información del nombre y descripcion del perfil de usuario
			if(count($request->input("credential"))==0)
				return redirect()->back()->withInput()->with("message",array("data"=>"Favor asignar al menos una credencial al perfil","type"=>"danger"));
			$profile = new User_profile;
			
			$profile->profile_name = $request->input("profile_name");
			$profile->profile_description = $request->input("profile_description");
			
			$message = array("data"=>"Perfil agregado con éxito.","type"=>"success");
			
			try{
				//se insertan las funcionalidades asociadas a ese perfil de usuario junto con su vinculo al perfil de usuario
				$profile->save();
				foreach($request->input("credential") as $credential){
					$user_credential = User_credential::firstOrCreate(["function_name"=>$credential]);
					
					$profile_credential = new Profile_credential;
					$profile_credential->fill(["id_user_profile"=>$profile->id,"id_user_credential"=>$user_credential->id,"credential"=>1])->save();
				}				
			}catch(\Illuminate\Database\QueryException $ex){				
				$message = array("data"=>"Excepcion al intentar ingresar los datos", "type"=>"danger");
				//deberemos generar una clase para almacenar las excepciones de IO en la BD para gestionarlas a posterior
			}
			
			return $this->getList($message);
	}	
	
	public function editProfile($id){
		$profile = User_profile::findOrFail($id);
		return view("users.profile-edit", Array("profile"=>$profile,"credentials"=>$this->getCredentials(),"user_credentials"=>$profile->user_credentials->pluck('function_name')->toArray()));
	}
	
	public function updateProfile($id, Request $request){
		//se inserta la información del nombre y descripcion del perfil de usuario
		if(count($request->input("credential"))==0)
			return redirect()->back()->withInput()->with("message",array("data"=>"Favor asignar al menos una credencial al perfil","type"=>"danger"));
			$profile = User_profile::findOrFail($id);
			
			$profile->profile_name = $request->input("profile_name");
			$profile->profile_description = $request->input("profile_description");
			
			$message = array("data"=>"Perfil modificado con éxito.","type"=>"success");
			
			try{
				//se insertan las funcionalidades asociadas a ese perfil de usuario junto con su vinculo al perfil de usuario
				$profile->save();
				Profile_credential::where("id_user_profile",$profile->id)->delete();
				
				foreach($request->input("credential") as $credential){
					$user_credential = User_credential::firstOrCreate(["function_name"=>$credential]);
					
					$profile_credential = new Profile_credential;
					$profile_credential->fill(["id_user_profile"=>$profile->id,"id_user_credential"=>$user_credential->id,"credential"=>1])->save();
				}
			}catch(\Illuminate\Database\QueryException $ex){
				$message = array("data"=>"Excepcion al intentar ingresar los datos", "type"=>"danger");
				//deberemos generar una clase para almacenar las excepciones de IO en la BD para gestionarlas a posterior
			}
			
			return $this->getList($message);
	}
	
	public function deleteProfile($id, Request $request){
		$message = array("data"=>"Perfil eliminado con éxito","type"=>"success");
		if($request->input("profile_id") == "delete"){
			//borrar usuarios
			try{
				//se insertan las funcionalidades asociadas a ese perfil de usuario junto con su vinculo al perfil de usuario
				$profile = User_profile::findOrFail($id);
				User::where("user_profile_id",$id)->delete();
				Profile_credential::where("id_user_profile",$profile->id)->delete();
				$profile->delete();
			}catch(\Illuminate\Database\QueryException $ex){
				$message = array("data"=>"Excepcion al intentar ingresar los datos", "type"=>"danger");
				//deberemos generar una clase para almacenar las excepciones de IO en la BD para gestionarlas a posterior
			}
			
		}else{
			//asignar usuarios a perfil
			try{
				$profile = User_profile::findOrFail($id);
				User::where("user_profile_id",$id)->update(["user_profile_id"=>$request->input("profile_id")]);
				Profile_credential::where("id_user_profile",$profile->id)->delete();
				$profile->delete();
			}catch(\Illuminate\Database\QueryException $ex){
				$message = array("data"=>"Excepcion al intentar ingresar los datos", "type"=>"danger");
				//deberemos generar una clase para almacenar las excepciones de IO en la BD para gestionarlas a posterior
			}
		}
		return redirect("profiles")->withInput()->with("message",$message);
		//return $this->getList($message);
	}
}
