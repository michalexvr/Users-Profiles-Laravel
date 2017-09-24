<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\User_profile;
use Illuminate\Support\Facades\Auth;
use App\Investor;
use App\Systemlog;

class UsersController extends Controller
{
	//
	public function getList($message = null){
		$users = User::All();
		$profiles = User_profile::All()->pluck("profile_name","id")->toArray();
		return view("users.list",Array("users"=>$users, "profiles"=>$profiles, "message"=>$message));
	}
	
	public function addUser($message = null){
		$profiles = User_profile::All();
		return view("users.add", Array("profiles"=>$profiles));
	}
	
	public function insertUser(Request $request){
		
		$user = new User;
		
		$user->name = $request->input("name");
		$user->email = $request->input("email");
		$user->password = bcrypt($request->input("password"));
		$user->user_profile_id= $request->input("user_profile_id");
		$message = array("data"=>"User added.","type"=>"success");
		
		
		try{
			$user->save();
		}catch(\Illuminate\Database\QueryException $ex){
			$message = array("data"=>"Exception trying insert the data: ".$ex, "type"=>"danger");
		}
		return $this->getList($message);
	}
	
	public function editUser($id){
		$user = User::findOrFail($id);
		$profiles = User_profile::All();
		return view("users.edit", Array("user"=>$user,"profiles"=>$profiles));
	}
	
	public function updateUser($id, Request $request){
		$user = User::findOrFail($id);
		
		if($request->input("name")!=null)$user->name = $request->input("name");
		if($request->input("email")!=email)$user->email = $request->input("email");
		if($request->input("user_profile_id")!=null)$user->user_profile_id = $request->input("user_profile_id");
		
		$message = array("data"=>"User modified.","type"=>"success");
		try{
			$user->save();
		}catch(\Illuminate\Database\QueryException $ex){
			$message = array("data"=>"Exception trying modify the data ".$ex, "type"=>"danger");
		}
		return $this->getList($message);
	}
	
	public function changePassword($id){
		$user = User::findOrFail($id);
		
		return view("users.password", Array("user"=>$user));
	}
	
	public function updatePassword($id, Request $request){
		if($request->input("password") != $request->input("password_confirm"))
			return redirect()->back()->withInput()->with("message",Array("type"=>"danger","data"=>"Password fields does not match!"));
			
			$user = User::findOrFail($id);
			
			$user->password = bcrypt($request->input("password"));
			$message = array("data"=>"Password changed.","type"=>"success");
			
			try{
				$user->save();
			}catch(\Illuminate\Database\QueryException $ex){
				$message = array("data"=>"Exception trying modify the data ".$ex, "type"=>"danger");
			}
			return $this->getList($message);
	}
	
	public function deleteUser($id){
		$user = User::findOrFail($id);
		
		$message = array("data"=>"User deleted", "type"=>"success");
		try{
			$user->delete();
		}catch(\Illuminate\Database\QueryException $ex){
			$message = array("data"=>"Exception trying delete the user ".$ex, "type"=>"danger");
		}
		
		return $this->getList($message);
	}
	
}
