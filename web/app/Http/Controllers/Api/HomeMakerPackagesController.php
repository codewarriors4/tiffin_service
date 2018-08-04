<?php

namespace TiffinService\Http\Controllers\Api;

use TiffinService\HomeMaker;
use TiffinService\HomeMakerPackages;
use Illuminate\Http\Request;
use TiffinService\Http\Controllers\Controller;
use TiffinService\User;


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

    	$homemaker_package_id = request('HMPId');

    	    $this->validate($request,[
        		
        		'HMPName' => 'required',
        		'HMPDesc' => 'required',
        		'HMPCost' => 'required'
        		]);


    	HomeMakerPackages::where('HMPId',$homemaker_package_id)->update(['HMPName' => request('HMPName'),'HMPDesc' => request('HMPDesc'),'HMPCost' => request('HMPCost')]);

       return response()->json(['status'=>'success'],200);
      	
      } catch (\Exception $e) {
      	dd($e);

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

    	

    	//Homekar View own packages 
    	public function HMPMyPackages(Request $request){

    		try{

    		$user_id = \Auth::user()->id;    		
    		

    		$home_maker_packages = HomeMaker::join('users','users.id','=','homemaker.UserId')
    		->join('homemakerpackages','homemaker.HMId','=','homemakerpackages.HomeMakerId')->where('id',$user_id)->orderBy('homemakerpackages.created_at', 'desc')->get();



    		return response()->json(['home_maker_packages'=>$home_maker_packages],200); 

    		}
    		catch(Exception $e){

    			return response()->json(['status'=>'failed'],203);

    		}

    	}

            //Homekar View a single package 
        public function HMPMyPackage(Request $request){

            try{

            //$user_id = \Auth::user()->id; 
            $homemaker_package_id = request('HMPId');

            if($homemaker_package_id =='' || $homemaker_package_id == null){
                return response()->json(['status'=>'failed'],203);
            }          
            

            $home_maker_packages = User::join('homemaker','homemaker.UserId','=','users.id')
            ->join('homemakerpackages','homemakerpackages.HomeMakerId','=','homemaker.HMId')->where('HMPId',$homemaker_package_id)->first();
                $home_maker_packages->hst = (0.02 * $home_maker_packages->HMPCost);
                $home_maker_packages->total = $home_maker_packages->hst + $home_maker_packages->HMPCost;

            return response()->json(['home_maker_packages'=>$home_maker_packages],200); 

            }
            catch(Exception $e){

                return response()->json(['status'=>'failed'],203);

            }

        }

    	//Tiffinseekers views a homemaker pakage

    	public function HMPListings(Request $request){

    		try{

    		$homemaker_id =request('HMId');

    		$home_maker_packages = HomeMaker::join('homemakerpackages','homemaker.HMId','=','homemakerpackages.HomeMakerId')->where('HMId',$homemaker_id)->get();


    		return response()->json(['home_maker_packages'=>$home_maker_packages],200); 

    		}
    		catch(Exception $e){

    			return response()->json(['status'=>'failed'],203);

    		}


    	}



}
