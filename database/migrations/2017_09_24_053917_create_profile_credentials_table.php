<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProfileCredentialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profile_credentials', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_user_profile')->unsigned();
            $table->integer('id_user_credential')->unsigned();
            $table->integer('credential');
            $table->timestamps();
            $table->foreign('id_user_profile')->references('id')->on('user_profiles');
            $table->foreign('id_user_credential')->references('id')->on('user_credentials');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('profiles_credentials');
    }
}
