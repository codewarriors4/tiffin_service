<?php

namespace TiffinService\Http\Controllers\Api;

use TiffinService\HomeMaker;
use TiffinService\HomeMakerPackages;
use Illuminate\Http\Request;
use TiffinService\Http\Controllers\Controller;

class HomeMakerPackagesController extends Controller
{    

	public function HMPCreate(Request $request){    

		try{

			$user_id = \Auth::user()->id;

    	    $this->validate($request,[
        		
        		'HMPName' => 'required',
        		'HMPDesc' => 'required',
        		'HMPCost' => 'required'

        		]);

    	    $home_maker = HomeMaker::where('UserId',$user_id)->first();    	    	
    	
        	$package_create = HomeMakerPackages::create([

        		'HMPName' => request('HMPName'),
        		'HMPDesc' => request('HMPDesc'),
        		'HMPCost' => request('HMPCost'),
        		'HomeMakerId' => $home_maker->HMId       

        		]);


        	return response()->json(['status'=>'success'],200);

		}
		catch(\Exception $e){

			return response()->json(['status'=>'failed'],203);


		}
		

        	

    }

    public function HMPUpdate(Request $request){  


    try {

    	$user_id = \Auth::user()->id;

		$home_maker = HomeMaker::where('UserId',$user_id)->firstOrFail();

    	    $this->validate($request,[
        		
        		'HMPName' => 'required',
        		'HMPDesc' => 'required',
        		'HMPCost' => 'required'
        		]);


    	HomeMakerPackages::where('HomeMakerId',$home_maker->HMId)->update(['HMPName' => request('HMPName'),'HMPDesc' => request('HMPDesc'),'HMPCost' => request('HMPCost')]);

       return response()->json(['status'=>'success'],200);
      	
      } catch (\Exception $e) {

      return response()->json(['status'=>'failed'],203);

      	
      }  

		

    }


        public function HMPDelete(Request $request){   


        try {

        $user_id = \Auth::user()->id;

		$home_maker = HomeMaker::where('UserId',$user_id)->firstOrFail();   

    	HomeMakerPackages::where('HomeMakerId',$home_maker->HMId)->where('HMPId',request('HMPId'))->delete();

       return response()->json(['status'=>'success'],200);

         	
         } catch (Exception $e) {

         	return response()->json(['status'=>'failed'],203);

         	
         } 

	
    }


}
