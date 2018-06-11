<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/	

//please avoid naming a route as 'home' as it conflicts with other routes										

Route::get('/', function () {
    return view('welcome');
})->name('main');

Route::post('register', 'Api\Auth\RegisterController@register');

Route::post('login', 'Api\Auth\LoginController@login');
Route::post('refresh', 'Api\Auth\LoginController@refresh');

Route::get('verify/{token}','Api\VerifyController@verify')->name('verify');

Route::middleware('auth:api')->group(function(){


		Route::post('logout', 'Api\Auth\LoginController@logout');
		Route::post('posts', 'Api\Auth\LoginController@refresh');

		/*Homemaker Package*/

		Route::post('createmenu', 'Api\HomeMakerPackagesController@HMPCreate')->name('createmenu');
		Route::post('updatemenu', 'Api\HomeMakerPackagesController@HMPUpdate')->name('updatemenu');
		Route::post('deletemenu', 'Api\HomeMakerPackagesController@HMPDelete')->name('deletemenu'); //requires to pass HMPId as request

		/* TiffinSeeker Search Homemaker */
		Route::post('gethomemakers', 'Api\HomeMakerSearchController@HMSearch')->name('gethomemakers'); //requires to pass HMPId as request













});
