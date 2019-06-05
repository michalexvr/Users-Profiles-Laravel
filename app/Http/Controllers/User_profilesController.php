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
			//first we insert the name and the description of the profile
			if(count($request->input("credential"))==0)
				return redirect()->back()->withInput()->with("message",array("data"=>"Plase assign at least one credential to the profile","type"=>"danger"));
			$profile = new User_profile;
			
			$profile->profile_name = $request->input("profile_name");
			$profile->profile_description = $request->input("profile_description");
			
			$message = array("data"=>"Profile added.","type"=>"success");
			
			try{
				//later, the functionalities to the profile are linked 
				$profile->save();
				foreach($request->input("credential") as $credential){
					$user_credential = User_credential::firstOrCreate(["function_name"=>$credential]);
					
					$profile_credential = new Profile_credential;
					$profile_credential->fill(["id_user_profile"=>$profile->id,"id_user_credential"=>$user_credential->id,"credential"=>1])->save();
				}				
			}catch(\Illuminate\Database\QueryException $ex){				
				$message = array("data"=>"Excepcion al intentar ingresar los datos", "type"=>"danger");
			}
			
			return $this->getList($message);
	}	
	
	public function editProfile($id){
		$profile = User_profile::findOrFail($id);
		return view("users.profile-edit", Array("profile"=>$profile,"credentials"=>$this->getCredentials(),"user_credentials"=>$profile->user_credentials->pluck('function_name')->toArray()));
	}
	
	public function updateProfile($id, Request $request){
		if(count($request->input("credential"))==0)
			return redirect()->back()->withInput()->with("message",array("data"=>"Favor asignar al menos una credencial al perfil","type"=>"danger"));
			$profile = User_profile::findOrFail($id);
			
			$profile->profile_name = $request->input("profile_name");
			$profile->profile_description = $request->input("profile_description");
			
			$message = array("data"=>"Profile modified.","type"=>"success");
			
			try{
				//FIRST WE DELETE ALL OLD CREDENTIALS BEFORE CHARGE THE NEW PERMISSIONS
				$profile->save();
				Profile_credential::where("id_user_profile",$profile->id)->delete();
				
				foreach($request->input("credential") as $credential){
					$user_credential = User_credential::firstOrCreate(["function_name"=>$credential]);
					
					$profile_credential = new Profile_credential;
					$profile_credential->fill(["id_user_profile"=>$profile->id,"id_user_credential"=>$user_credential->id,"credential"=>1])->save();
				}
			}catch(\Illuminate\Database\QueryException $ex){
				$message = array("data"=>"Exception trying insert the data", "type"=>"danger");
			}
			
			return $this->getList($message);
	}
	
	public function deleteProfile($id, Request $request){
		$message = array("data"=>"Profile deleted","type"=>"success");
		if($request->input("profile_id") == "delete"){
			//delete users option
			try{
				$profile = User_profile::findOrFail($id);
				
				if($profile->profile_name == "admin") return redirect()->back()->with(array("message"=>array("data"=>"Admin profile could not be deleted", "type"=>"danger"))); 
				User::where("user_profile_id",$id)->delete();
				Profile_credential::where("id_user_profile",$profile->id)->delete();
				$profile->delete();
			}catch(\Illuminate\Database\QueryException $ex){
				$message = array("data"=>"Exception trying delete the profile ".$ex, "type"=>"danger");
			}
			
		}else{
			//transfer user to another profile option
			try{
				$profile = User_profile::findOrFail($id);
				User::where("user_profile_id",$id)->update(["user_profile_id"=>$request->input("profile_id")]);
				Profile_credential::where("id_user_profile",$profile->id)->delete();
				$profile->delete();
			}catch(\Illuminate\Database\QueryException $ex){
				$message = array("data"=>"Excepcion trying modify the data ".$ex, "type"=>"danger");
			}
		}
		return redirect("profiles")->withInput()->with("message",$message);
	}
}
