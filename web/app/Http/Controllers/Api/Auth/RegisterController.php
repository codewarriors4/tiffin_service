<?php

namespace App\Http\Controllers\Api\Auth;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controller;
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

    		]);

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
}
