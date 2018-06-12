<?php

namespace TiffinService\Http\Controllers\Api\Auth;
use TiffinService\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Laravel\Passport\Client;
use TiffinService\Http\Controllers\Controller;

class LoginController extends Controller
{
    

	private $client;

	public function __construct(){

		$this->client = Client::find(2);

	}

    public function login(Request $request){

    	$this->validate($request,[
    		
    		'email' => 'required',
    		'password' => 'required'

    		]);

        $user = User::where('email',request('email'))->first();

       

        if($user->count() > 0){

            if($user->isEmailVerified == 0){

                return response()->json(['error','Email not verified'],201);
            }

        }



    	$params = [
    		'grant_type' => 'password',
    		'client_id' => $this->client->id,
    		'client_secret' => $this->client->secret,    		
    		'username' => request('email'),
    		'password' => request('password'),
    		'scope' => '*'

    	];

    	$request->request->add($params);
    	$proxy = Request::create('oauth/token','POST');
    	return Route::dispatch($proxy);
    }

    public function refresh(Request $request){

    	$this->validate($request, [
    			'refresh_token' => 'required'
    		]);

    	$params = [
    	    'grant_type' => 'refresh_token',
    		'client_id' => $this->client->id,
    		'client_secret' => $this->client->secret,    		
    		'username' => request('email'),
    		'password' => request('password')

    	];

    	$request->request->add($params);
    	$proxy = Request::create('oauth/token','POST');
    	return Route::dispatch($proxy);
    }

    public function logout(Request $request){
    	 $accessToken = Auth::user()->token();

    	// DB:: table('oauth_refresh_tokens')->where('access_token_id',$accessToken->id)->update(['revoked'] => true);

    	 $accessToken->revoke();

    	 return response()->json([],204);
    }
}
