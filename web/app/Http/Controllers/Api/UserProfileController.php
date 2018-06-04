<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;

class UserProfileController extends Controller
{
    private $client;

    public function tiffinSeekercreate(Request $request)
    {
    	$authid = \Auth::user()->id;
    	#$name=request('UserFname');
    	$users=User::find($authid);
    	$users->UserFname=request('UserFname');
    	$users->UserLname=request('UserLname');
    	$users->UserType=request('UserType');
    	$users->UserPhone=request('UserPhone');
    	$users->UserCountry=request('UserCountry');
    	$users->UserProvince=request('UserProvince');
    	$users->UserCity=request('UserCity');
    	$users->UserZipCode=request('UserZipCode');
    	$users->UserPhone=request('UserPhone');
    	$users->UserCompanyName=request('UserCompanyName');
    	$users->save();

    	if($request->hasFile('file')){

    		#$dir=.$request->user()->id;
    		$request->file->storeAs('public/upload/'.$request->user()->id,$request->user()->id.'.'.$request->file->getClientOriginalExtension());
    		return('yes');
    	}
    	else{
    		dd('no');
    	}
    }

	public function tiffinseekerprofileview()
	{

	}
}
