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
Route::get('/success', 'AdminController@showSuccessPage')->name('success');

Route::get('/admin/login', 'AdminController@showloginform')->name('adminloginget');
Route::get('/manageusers', ['as' => 'manageusers', 'uses' => 'Admin\ManageUsersController@showusers']);

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

Route::get('/approve/{id}', 'AdminController@approveUser')->name('approveUser');


/*Route::get('password/reset', 'Api\Auth\ForgotPasswordController@showLinkRequestForm')->name('password.reset');
Route::post('password/email', 'Api\Auth\ForgotPasswordController@showResetForm')->name('password.email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset.token');
Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('password.request');*/

Route::group(array('prefix' => 'admin'), function () {

    Route::get('/edit/{id}', ['as' => 'editLink', 'uses' => 'AdminController@editUser']);


    Route::get('/createdriver', ['as' => 'createDriver', 'uses' => 'AdminController@createDriver']);
    Route::post('/updateuser/{id}', ['as' => 'updateuser', 'uses' => 'AdminController@updateUser']);



    Route::post('/savedriver', ['as' => 'saveDriver', 'uses' => 'AdminController@saveDriver']);
    Route::post('/createlink', ['as' => 'createlink', 'uses' => 'WebsiteContentController@createLink']);
});
