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

Route::post('password/email', 'Api\Auth\ForgotPasswordController@getResetToken');
Route::post('/UserPasswordReset','Api\Auth\ForgotPasswordController@sendResetLink');

	
//Route::post('password/reset', 'Auth\ResetPasswordController@reset');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm');



Route::middleware('auth:api')->group(function(){

		Route::post('/user', function() {
	        return response()->json(request()->user());
	    });


		Route::post('logout', 'Api\Auth\LoginController@logout');
		Route::post('posts', 'Api\Auth\LoginController@refresh');
		
		Route::post('tiffinseekerprofile', 'Api\UserProfileController@tiffinSeekercreate');
		Route::post('tiffinseekerprofileview', 'Api\UserProfileController@tiffinseekerprofileview');

		
		Route::post('homemakerprofile','Api\UserProfileController@homemakerprofilecreate');
		Route::post('homemakerprofileview','Api\UserProfileController@homemakerprofileview');
	
	/*Subscription*/

		Route::post('homemakersubscribers','Api\UserSubscriberController@homemakersubscriberview');
		Route::post('homemakersubscribermonthly','Api\UserSubscriberController@homemakersubscriberviewmonthly');
		Route::post('homemakersubscriberdaily','Api\UserSubscriberController@homemakersubscriberviewdaily');

		Route::post('tiffinseekersubscribtions','Api\UserSubscriberController@tiffinseekersubscribtionview');
/*		Route::post('tiffinseekersubscribermonthly','Api\UserSubscriberController@tiffinseekersubscriberviewmonthly');
		Route::post('tiffinseekersubscriber','Api\UserSubscriberController@tiffinseekersubscriberviewdaily'); */


	/*Homemaker Package*/

		Route::post('createmenu', 'Api\HomeMakerPackagesController@HMPCreate')->name('createmenu');
		Route::post('updatemenu', 'Api\HomeMakerPackagesController@HMPUpdate')->name('updatemenu');
		Route::post('deletemenu', 'Api\HomeMakerPackagesController@HMPDelete')->name('deletemenu'); //requires to pass HMPId as request
		Route::get('mypackages', 'Api\HomeMakerPackagesController@HMPMyPackages')->name('mypackages'); //view packages	
		Route::post('mypackage', 'Api\HomeMakerPackagesController@HMPMyPackage')->name('mypackage'); //view packages			



		// View Homemaker packagae by Tifiinseeker
		Route::get('viewpackages/{HMId}', 'Api\HomeMakerPackagesController@HMPListings')->name('viewpackages'); //


		/* TiffinSeeker Search Homemaker */
		Route::post('gethomemakers', 'Api\HomeMakerSearchController@HMSearch')->name('gethomemakers'); //requires to pass HMPId as request

		// TiffinSeeker view Homemaker profile
		Route::post('tsviewhmprofile/{userId}', 'Api\UserController@tiffinSeekerViewHomeMaker')->name('tsviewhmprofile'); //


		/* Add to Cart */
		Route::post('addToCart', 'Api\PaymentController@AddToCart')->name('addToCart');

		Route::post('cartsummary', 'Api\PaymentController@CartSummary')->name('cartsummary');

		/* Payment */
		Route::post('payment', 'Api\PaymentController@Payment')->name('payment');


		/* store fcm token to db */

		Route::post('fcmtokenstore', 'Api\UserController@storeFCMToken')->name('fcmtokenstore');





		















});
