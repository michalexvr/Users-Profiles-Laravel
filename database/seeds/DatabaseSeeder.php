<?php

use Illuminate\Database\Seeder;
use App\User;
use App\User_credential;
use App\User_profile;
use App\Profile_credential;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);

        //function name "*" is our god-mode!
        $user_credential = User_credential::create(array("function_name"=>"*"));
        
        //we create our administrator profile
        $user_profile = User_profile::create(array("profile_name"=>"admin","profile_description"=>"System Administrator"));
        
        //we vinculate the credential with the profile here:
        Profile_credential::create(array("id_user_profile"=>$user_credential->id,"id_user_credential"=>$user_profile->id,"credential"=>1));
        
        //we create our first user with admin privileges, email could be changed
        User::create(array("name"=>"Administrator","email"=>"admin@system.dom","password"=>bcrypt("admin"),"user_profile_id"=>$user_profile->id));
    }
}
