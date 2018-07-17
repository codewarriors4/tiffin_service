<?php

namespace TiffinService\Http\Controllers\Api;

use TiffinService\User;
use Illuminate\Support\Facades\Config;
use Illuminate\Http\Request;
use TiffinService\Http\Controllers\Controller;

class HomeMakerSearchController extends Controller
{

	    public function GetMatchedZipCodes($tiffinseeker_zip){ 

     	$radius = Config::get('constants.options.searchradius');

     	$matched_zipcodes_array=array();

     	$url = 'https://www.zipwise.com/webservices/radius.php?key=hky2tzcwg83xmkzt
&zip='.$tiffinseeker_zip.'&radius='.$radius.'&format=json';

		$client = new \GuzzleHttp\Client();
		$response = $client->get($url);


		$responseJSON = json_decode($response->getBody(), true);

      //  dd($responseJSON['results']);

        dd($responseJSON['results']);

		if(count($responseJSON['results'])>0){

			foreach (($responseJSON['results']) as $key => $value) {
                print_r($responseJSON['results']);

				//array_push($matched_zipcodes_array, $value['zip']);				
				
			}
		}

//dd($matched_zipcodes_array);
		return $matched_zipcodes_array;		

		//dd($responseJSON['results'][0]); //     	

     }
    
    public function HMSearch(Request $request){  

    	

    	$tiffinseeker_zip = str_replace(' ', '', request('ZipCode')); //remove any spqces from zip
    	

    	$nearbyzip_array = self::GetMatchedZipCodes($tiffinseeker_zip);



    	$matched_zipcodes = User::whereIn('UserZipcode', $nearbyzip_array)->join('homemaker', 'homemaker.UserId', '=', 'users.id')->where('users.isActive',1)->get();

    	

        	return response()->json(['matched_homemakers'=>$matched_zipcodes,'status'=>'success'], 200);
    	
    	
 	

    }

 
}
