<?php

namespace TiffinService\Http\Controllers\Api;

use TiffinService\HomeMaker;
use Illuminate\Http\Request;
use TiffinService\Http\Controllers\Controller;
use TiffinService\User;
use TiffinService\subscription;
use TiffinService\tiffinseeker;

Class UserSuscriberController extends Controller
{

	public function homemakersubscriberviewdaily(Request $request)
	{

	}
	public function homemakersubscriberviewmonthly(Request $request)
	{
		
	}
	public function homemakersubscriberview(Request $request)
	{

		try {
			
		
		$authid = \Auth::user()->id;
    	$users=User::find($authid);

    	#dd($users);

		$userId=HomeMaker::where('UserId',$authid)->first();
		#dd($userId->HMId);
		$dt = new \DateTime();
		$dt->format('Y-m-d H:i:s');
#dd($dt->date);
		$data=User::join('tiffinseeker','tiffinseeker.UserId','=','users.id')
		->join('subscription','subscription.TiffinSeekerId','=','tiffinseeker.TSid')
		->join('homemakerpackages','homemakerpackages.HMPId','=','subscription.HMPid')
		->join('homemaker','homemaker.HMId','=','subscription.HomeMakerId')
		->where('subscription.SubEndDate','<',$dt)
		->where('homemaker.HMId',$userId->HMId)->get();
	
			return response()->json($data,200);

		} 
		catch (Exception $e) 
		{
			response()->json(['status'=>'amit_suks'],203);
		}
	}


	public function tiffinseekersubscribtionview()
	{
		try {
			
		$authid = \Auth::user()->id;
    	$users=User::find($authid);

		$userId=tiffinseeker::where('TSId',$authid)->first();
		#dd($userId->TSId);

		$data=User::join('tiffinseeker','tiffinseeker.UserId','=','users.id')
		->join('subscription','subscription.TiffinSeekerId','=','tiffinseeker.TSid')
		->join('homemakerpackages','homemakerpackages.HMPId','=','subscription.HMPid')
		->join('homemaker','homemaker.HMId','=','subscription.HomeMakerId')
		->where('tiffinseeker.TSId',$userId->TSId)->get();

			return response()->json($data,200);

		} 
		catch (Exception $e) 
		{
			response()->json(['status'=>'amit_suks'],203);
		}
	}

}