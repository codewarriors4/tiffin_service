<?php

namespace TiffinService\Http\Controllers\Api;

use Illuminate\Http\Request;
use TiffinService\HomeMaker;
use TiffinService\Http\Controllers\Controller;
use TiffinService\Reviews;
use TiffinService\TiffinSeeker;
use TiffinService\User;

class RatingsController extends Controller
{

    public function createorUpdateRating(Request $request)
    {
        try {

            $authid = \Auth::user()->id;
            $ts_id  = TiffinSeeker::where('UserId', $authid)->first();

            $this->validate($request, [

                'HomeMakerID' => 'required',
                'ReviewDesc'  => 'required',
                'ReviewCount' => 'required',
            ]);

            $review_existing_ct = Reviews::where('HomeMakerID', request('HomeMakerID'))->where('TiffinSeekerId', $ts_id->TSId)->get();

            if ($review_existing_ct->count() == 0) {

                $package_create = Reviews::create([

                    'HomeMakerID'    => request('HomeMakerID'),
                    'TiffinSeekerId' => $ts_id->TSId,
                    'ReviewDesc'     => request('ReviewDesc'),
                    'ReviewCount'    => request('ReviewCount'),

                ]);
                
            } else {

                $reviews = Reviews::where('HomeMakerID', request('HomeMakerID'))->where('TiffinSeekerId', $ts_id->TSId)->update(['ReviewDesc' => request('ReviewDesc'), 'ReviewCount' => request('ReviewCount')]);

            }

            $avg_ratings = $this->calcAvgRatings(request('HomeMakerID'));

            $avg_ratings = round(2 * $avg_ratings) / 2;

            HomeMaker::where('HMId', request('HomeMakerID'))->update(['AverageRatings' => $avg_ratings]);

            return response()->json(['status' => 'success'], 200);

        } catch (Exception $e) {
            return response()->json(['status' => 'failed'], 203);
        }


    }

    public function viewRating(Request $request){

         $authid = \Auth::user()->id;
         $ts_id  = TiffinSeeker::where('UserId', $authid)->first();       

         $review_existing_ct = Reviews::where('HomeMakerID', request('HomeMakerID'))->where('TiffinSeekerId', $ts_id->TSId)->get();

        return response()->json([$review_existing_ct], 200);  


    }

    public function calcAvgRatings($HMId)
    {

        $rating_array = array("1.0" => 0, "1.5" => 0, "2.0" => 0, "2.5" => 0, "3.0" => 0, "3.5" => 0, "4.0" => 0, "4.5" => 0, "5.0" => 0);

        $rating_count_individual = Reviews::where('HomeMakerID', $HMId)->select('ReviewCount')->get()->toArray();

        $people_count  = 0;
        $total_ratings = 0;

        if (count($rating_count_individual) > 0) {
            foreach ($rating_count_individual as $key => $value) {

                if ($value["ReviewCount"] == 1) {
                    $rating_array["1.0"] = $rating_array["1"] + 1;
                } else if ($value["ReviewCount"] == 1.5) {
                    $rating_array["1.5"] = $rating_array["1.5"] + 1;

                } else if ($value["ReviewCount"] == 2) {

                    $rating_array["2.0"] = $rating_array["2"] + 1;

                } else if ($value["ReviewCount"] == 2.5) {

                    $rating_array["2.5"] = $rating_array["2.5"] + 1;

                } else if ($value["ReviewCount"] == 3) {

                    $rating_array["3.0"] = $rating_array["3.0"] + 1;

                } else if ($value["ReviewCount"] == 3.5) {

                    $rating_array["3.5"] = $rating_array["3.5"] + 1;

                } else if ($value["ReviewCount"] == 4) {

                    $rating_array["4.0"] = $rating_array["4.0"] + 1;

                } else if ($value["ReviewCount"] == 4.5) {

                    $rating_array["4.5"] = $rating_array["4.5"] + 1;

                } else if ($value["ReviewCount"] == 5) {

                    $rating_array["5.0"] = $rating_array["5.0"] + 1;

                }

            }
        }

        foreach ($rating_array as $key => $value) {
            $people_count  = $people_count + $value;
            $total_ratings = ($key * $value) + $total_ratings;
        }

        $avg_rating = $total_ratings / $people_count;

        return number_format((float) $avg_rating, 1, '.', '');

    }

    public function viewHMRatings(Request $request)
    {

        try {

            $this->validate($request, [

                'HomeMakerID' => 'required',

            ]);

            $hmID = request('HomeMakerID');

            $reviews = \DB::table('users as u1')
                ->leftJoin('homemaker', 'homemaker.UserId', '=', 'u1.id')
                ->leftJoin('review', 'review.HomeMakerID', '=', 'homemaker.HMId')
                ->leftJoin('tiffinseeker', 'tiffinseeker.TSId', '=', 'review.TiffinSeekerId')
                ->leftJoin('users as u2', 'u2.id', '=', 'tiffinseeker.UserId')
                ->select('u1.id as HomeMakerUserId', 'u1.email as HomeMakerEmail', 'u1.isEmailVerified as HomeMakerisEmailVerified', 'u1.isActive as HomeMakerisActive', 'u1.UserFname as HomeMakerUserFname', 'u1.UserLname as HomeMakerUserLname', 'u1.UserType as HomeMakerUserType', 'u1.UserPhone as HomeMakerUserPhone', 'u1.UserStreet as HomeMakerUserStreet', 'u1.UserCountry as HomeMakerUserCountry', 'u1.UserProvince as HomeMakerUserProvince', 'u1.UserCity as HomeMakerUserCity', 'u1.UserZipCode as HomeMakerUserZipCode', 'u1.UserCompanyName as HomeMakerUserCompanyName', 'u1.isBlocked as HomeMakerisBlocked', 'u2.*', 'review.*')
                ->where('HomeMakerID', $hmID)->get();

            return response()->json($reviews, 200);

        } catch (Exception $e) {

            return response()->json(['status' => 'failed'], 203);


        }

        /*  $reviews = User::join('homemaker','homemaker.UserId','=','users.id')
    ->join('review','review.HomeMakerID','=','homemaker.HMId')
    ->join('tiffinseeker','tiffinseeker.TSId','=','review.TiffinSeekerId')
    ->join('users','users.id','=','tiffinseeker.UserId')
    ->where('HomeMakerID',$hmID)->get();*/

    }

}
