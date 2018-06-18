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
    	try {
    		
    	 

    	$this->validate($request,[
        		
        		'UserFname' => 'required',
        		'UserLname' => 'required',
        		'UserType' => 'required',
        		'UserStreet'=>'required',
        		'UserZipCode' => 'required',
        		'UserPhone'=>'required'
        		]);

    	$authid = \Auth::user()->id;
    	#$name=request('UserFname');
    	$users=User::find($authid);
    	$users->UserFname=request('UserFname');
    	$users->UserLname=request('UserLname');
    	$users->UserType=request('UserType');
    	$users->UserPhone=request('UserPhone');
    	$users->UserStreet=request('UserStreet');
    	$users->UserCountry=request('UserCountry');
    	$users->UserProvince=request('UserProvince');
    	$users->UserCity=request('UserCity');
    	$users->UserZipCode=request('UserZipCode');
    	$users->UserPhone=request('UserPhone');
    	$users->UserCompanyName=request('UserCompanyName');
    	$users->save();

    	if($request->hasFile('file')){

    		#$dir=.$request->user()->id;
    		$request->file->storeAs('public/upload/'.$request->user()->id,'profileimage'.'.'.$request->file->getClientOriginalExtension());
    		return('yes');
    	}
    	else{
    		dd('no');
    	}

    	return response()->json(['status'=>'amit_good'],200);
    		
    	} catch (\Exception $e) {

    		return response()->json(['status'=>'amit_suks'],203);
    	}



    }

	public function tiffinseekerprofileview()
	{
		try {
			
		$authid = \Auth::user()->id;
		$users=User::find($authid);
		return response()->json($users,200);
		#return response()->json(['name' => 'ok'],200);
		} catch (Exception $e) {
			return response()->json(['status'=>'amit_suks'],203);
			
		}
		
	}


	public function homemakerprofilecreate(Request $request)
	{
		$authid = \Auth::user()->id;
		if($request->hasFile('file')){

    		#$dir=.$request->user()->id;
    		$request->file->storeAs('public/upload/'.$request->user()->id,'license'.'.'.$request->file->getClientOriginalExtension());
    		$image='license'.'.'.$request->file->getClientOriginalExtension();

    		$homemaker=HomeMaker::where('UserId'=>$authid)->update(['HMFoodLicense' => $image]);
    		#$homemaker->UserId=request($authid);
    		#$temp='public/upload/'.$request->user()->id;
    		#$homemaker->HMFoodLicense=request($temp);
    		#$homemaker->save();
    		#tiffin_service::table('homemaker')->insert(['UserId'=>'authid','HMFoodLicense'=>$request->file->getClientOriginalName()]);
    	return('yes');
    	}
    	else{

    		$homemaker=HomeMaker::find('UserId'=>$authid)=>get();

    		if($homemaker->HMFoodLicense==null){
    			
    			 $this->validate($request,[
        		'HMFoodLicense' => 'required',
        		]);
				}

    	}

 $this->validate($request,[
        		
        		'UserFname' => 'required',
        		'UserLname' => 'required',
        		'UserType' => 'required',
        		'UserStreet'=>'required',
        		'UserZipCode' => 'required',
        		'UserPhone'=>'required'

        		]);

		#$authid = \Auth::user()->id;
    	#$name=request('UserFname');
    	$users=User::find($authid);
    	$users->UserFname=request('UserFname');
    	$users->UserLname=request('UserLname');
    	$users->UserType=request('UserType');
    	$users->UserPhone=request('UserPhone');
    	$users->UserStreet=request('UserStreet');
    	$users->UserCountry=request('UserCountry');
    	$users->UserProvince=request('UserProvince');
    	$users->UserCity=request('UserCity');
    	$users->UserZipCode=request('UserZipCode');
    	$users->UserPhone=request('UserPhone');
    	$users->UserCompanyName=request('UserCompanyName');
    	$users->save();

    	


	}

	public function homemakerprofileview()
	{
		$authid = \Auth::user()->id;
		$users=User::find($authid);
		return response()->json($users,200);
		#return response()->json(['name' => 'ok'],200);
	}
}

