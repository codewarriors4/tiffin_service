<?php

namespace TiffinService\Http\Controllers\Api\Auth;
use TiffinService\User;
use TiffinService\TiffinSeeker;
use TiffinService\HomeMaker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use TiffinService\Http\Controllers\Controller;
use Laravel\Passport\Client;

class RegisterController extends Controller
{
    
	private $client;

	public function __construct(){

		$this->client = Client::find(2);

	}

    public function register(Request $request)
    {


        	$this->validate($request,[
        		
        		'email' => 'required|email|unique:users,email',
        		'password' => 'required|min:6|confirmed'

        		]);

        	$user = User::create([
        		
        		'email' => request('email'),
        		'password' => bcrypt(request('password')),
                'token' => str_random(25),

        		]);


            if(request('UserType') == 0){ // check if user is tiffinseeker
                
                $tiffin_seeker = TiffinSeeker::create([
                
                'UserId' => $user->id,       

            ]);


            }
            else if (request('UserType') == 1){ // check if user is homemaker

                $home_maker = HomeMaker::create([
                
                'UserId' => $user->id,       

            ]);


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

        $user->sendVerificationEmail();

    	return Route::dispatch($proxy);


    }
}
