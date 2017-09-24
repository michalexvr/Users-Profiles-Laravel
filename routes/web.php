<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('users','UsersController@getList')->name("List users")->middleware(['auth','has_access']);
Route::get('users/add','UsersController@addUser')->name("Add User")->middleware(['auth','has_access']);
Route::post('users/add','UsersController@insertUser')->name("Add User")->middleware(['auth','has_access']);
Route::get('users/edit/{i}','UsersController@editUser')->name("Edit User")->middleware(['auth','has_access']);
Route::post('users/edit/{i}','UsersController@updateUser')->name("Edit User")->middleware(['auth','has_access']);
Route::get('users/password/{i}','UsersController@changePassword')->name("Change Password")->middleware(['auth','has_access']);
Route::post('users/password/{i}','UsersController@updatePassword')->name("Change Password")->middleware(['auth','has_access']);
Route::get('users/delete/{i}','UsersController@deleteUser')->name("Delete User")->middleware(['auth','has_access']);

Route::get('profiles','User_profilesController@getList')->name('List Profiles')->middleware(['auth','has_access']);
Route::get('profiles/add','User_profilesController@addProfile')->name('Add Profile')->middleware(['auth','has_access']);
Route::post('profiles/add','User_profilesController@insertProfile')->name('Add Profile')->middleware(['auth','has_access']);
Route::get('profiles/edit/{i}','User_profilesController@editProfile')->name('Edit Profile')->middleware(['auth','has_access']);
Route::post('profiles/edit/{i}','User_profilesController@updateProfile')->name('Edit Profile')->middleware(['auth','has_access']);
Route::post('profiles/delete/{i}','User_profilesController@deleteProfile')->name('Delete Profile')->middleware(['auth','has_access']);
