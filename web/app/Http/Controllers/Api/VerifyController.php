<?php

namespace TiffinService\Http\Controllers\Api;
use TiffinService\User;
use Illuminate\Http\Request;
use TiffinService\Http\Controllers\Controller;

class VerifyController extends Controller
{
    public function verify($token){    

    	User::where('token',$token)->firstOrFail()->update(['token' => null,'isEmailVerified'=>1]);

    	return redirect()->route('success');

    }
}
