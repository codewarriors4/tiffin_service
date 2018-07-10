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
	\Auth::logout();
    return view('welcome');
});

Route::get('/admin/login', 'AdminController@showloginform')->name('adminloginget');
Route::get('/manageusers',                      [ 'as'=>'manageusers' ,                     'uses'=> 'Admin\ManageUsersController@showusers']);


Route::post('adminlogin', 'AdminController@authenticateAdmin')->name('adminlogin');
//Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/resetdone', function () {

	return view('resetdoneview');
});

Auth::routes();

Route::get('login', function () {



	\Auth::logout();
    return view('welcome');
});






