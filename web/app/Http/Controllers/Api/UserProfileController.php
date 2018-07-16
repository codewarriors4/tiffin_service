<?php

namespace TiffinService\Http\Controllers\Api;

use TiffinService\HomeMaker;
use Illuminate\Http\Request;
use TiffinService\Http\Controllers\Controller;
use TiffinService\User;

class UserProfileController extends Controller
{
    private $client;

    public function tiffinSeekercreate(Request $request)
    {
    	try {
    		
    	 

    	$this->validate($request,[
        		
        		'UserFname' => 'required',
        		'UserLname' => 'required',
        	
        		'UserStreet'=>'required',
        		'UserZipCode' => 'required',
        		'UserPhone'=>'required'
        		]);

    	$authid = \Auth::user()->id;
    	#$name=request('UserFname');
    	$users=User::find($authid);
    	$users->UserFname=request('UserFname');
    	$users->UserLname=request('UserLname');
    	
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
		try {
			
		
		$authid = \Auth::user()->id;
		if($request->hasFile('file')){

    		#$dir=.$request->user()->id;
    		$request->file->storeAs('public/upload/'.$request->user()->id,'license'.'.'.$request->file->getClientOriginalExtension());
    		$image='license.'.$request->file->getClientOriginalExtension();

    		$homemaker = HomeMaker::where('UserId',$authid)->update(['HMFoodLicense' => $image]);

    	}
    	else{

    		$homemaker=HomeMaker::where('UserId',$authid)->first();

	    		if(($homemaker->HMFoodLicense) == null || ($homemaker->HMFoodLicense) == ''){
    			 $this->validate($request,[
        		'HMFoodLicense' => 'required',
        		]);
				}

    	}
 $this->validate($request,[        		
        		'UserFname' => 'required',
        		'UserLname' => 'required',        		
        		'UserStreet'=>'required',
        		'UserZipCode' => 'required',
        		'UserPhone'=>'required',
                'HMLicenseExpiryDate'=>'required'
        		]);

        

        

		#$authid = \Auth::user()->id;
    	#$name=request('UserFname');
    	$users=User::find($authid);
    	$users->UserFname=request('UserFname');
    	$users->UserLname=request('UserLname');
        	$users->UserPhone=request('UserPhone');
    	$users->UserStreet=request('UserStreet');
    	$users->UserCountry=request('UserCountry');
    	$users->UserProvince=request('UserProvince');
    	$users->UserCity=request('UserCity');
    	$users->UserZipCode=request('UserZipCode');
    	$users->UserPhone=request('UserPhone');
    	$users->UserCompanyName=request('UserCompanyName');
    	$users->save();

//set the expiry date fpr license
        $dt = \Carbon\Carbon::parse(request('HMLicenseExpiryDate'));
        HomeMaker::where('UserId',$authid)->update(['HMLicenseExpiryDate' => $dt]); 
		
		return response()->json(['status'=>'amit_good'],200);

    	} catch (Exception $e) {
			return response()->json(['status'=>'amit_suks'],203);
		}
	}

	public function homemakerprofileview()
	{
		try {
			
		
		$authid = \Auth::user()->id;

        $users=User::join('homemaker', 'homemaker.UserId', '=', 'users.id')->where('id',$authid)->first();
		return response()->json($users,200);
		#return response()->json(['name' => 'ok'],200);
	} catch (Exception $e) {
			return response()->json(['status'=>'amit_suks'],203);
		}
	}
}

