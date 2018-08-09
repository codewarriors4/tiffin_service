<?php

namespace TiffinService\Http\Controllers\Api;

use Illuminate\Http\Request;
use TiffinService\HomeMaker;
use TiffinService\Http\Controllers\Controller;
use TiffinService\TiffinSeeker;
use TiffinService\User;

use TiffinService\DriverTasks;
use TiffinService\Reviews;

class UserSubscriberController extends Controller
{

    public function homemakersubscriberviewdaily(Request $request)
    {
        try {

            $authid = \Auth::user()->id;
            $users  = User::find($authid);

            #dd($users);
            $dt              = \Carbon\Carbon::now();

            $userId = HomeMaker::where('UserId', $authid)->first();
            #dd($userId->HMId);

#dd($dt->date);
            $data = User::join('tiffinseeker', 'tiffinseeker.UserId', '=', 'users.id')
                ->join('subscription', 'subscription.TiffinSeekerId', '=', 'tiffinseeker.TSid')
                ->join('homemakerpackages', 'homemakerpackages.HMPId', '=', 'subscription.HMPid')
                ->join('homemaker', 'homemaker.HMId', '=', 'subscription.HomeMakerId')
                ->where('subscription.SubEndDate','>=', $dt->format('Y-m-d')." 00:00:00")
                ->where('subscription.HomeMakerId', $userId->HMId)->orderBy('subscription.created_at', 'desc')->get();

            return response()->json($data, 200);

        } catch (Exception $e) {
            response()->json(['status' => 'amit_suks'], 203);
        }
    }
    public function homemakersubscriberviewmonthly(Request $request)
    {

        try {

            $authid = \Auth::user()->id;
            $users  = User::find($authid);

            #dd($users);

            $userId = HomeMaker::where('UserId', $authid)->first();
            //dd($userId->HMId);

            $dt              = \Carbon\Carbon::now();
         

//dd($next_month_date);
            $data = User::join('tiffinseeker', 'tiffinseeker.UserId', '=', 'users.id')
                ->join('subscription', 'subscription.TiffinSeekerId', '=', 'tiffinseeker.TSid')
                ->join('homemakerpackages', 'homemakerpackages.HMPId', '=', 'subscription.HMPid')
                ->join('homemaker', 'homemaker.HMId', '=', 'subscription.HomeMakerId')
                ->whereBetween('subscription.SubEndDate', [$dt->format('Y-m-d')." 00:00:00", $dt->addDays(30)->format('Y-m-d')." 23:59:59"])
                ->where('subscription.HomeMakerId', $userId->HMId)->orderBy('subscription.created_at', 'desc')->get();


            return response()->json($data, 200);

        } catch (Exception $e) {
            response()->json(['status' => 'amit_suks'], 203);
        }

    }
    public function homemakersubscriberview(Request $request)
    {

        try {

            $authid = \Auth::user()->id;
            $users  = User::find($authid);

         //   dd($authid);

            #dd($users);

            $userId = HomeMaker::where('UserId', $authid)->first();
            #dd($userId->HMId);

#dd($dt->date);
            $data = User::join('tiffinseeker', 'tiffinseeker.UserId', '=', 'users.id')
                ->join('subscription', 'subscription.TiffinSeekerId', '=', 'tiffinseeker.TSid')
                ->join('homemakerpackages', 'homemakerpackages.HMPId', '=', 'subscription.HMPid')
                ->join('homemaker', 'homemaker.HMId', '=', 'subscription.HomeMakerId')
                ->where('subscription.HomeMakerId', $userId->HMId)->orderBy('subscription.created_at', 'desc')->get();

            return response()->json($data, 200);

        } catch (Exception $e) {
            response()->json(['status' => 'amit_suks'], 203);
        }
    }
/*
    public function tiffinseekersubscriberviewdaily(Request $request)
    {
        try {

            $authid = \Auth::user()->id;
            $users  = User::find($authid);

            #dd($users);
            $dt              = \Carbon\Carbon::now();

            $userId = TiffinSeeker::where('UserId', $authid)->first();
            #dd($userId->HMId);

#dd($dt->date);
            $data = User::join('tiffinseeker', 'tiffinseeker.UserId', '=', 'users.id')
                ->join('subscription', 'subscription.TiffinSeekerId', '=', 'tiffinseeker.TSid')
                ->join('homemakerpackages', 'homemakerpackages.HMPId', '=', 'subscription.HMPid')
                ->join('homemaker', 'homemaker.HMId', '=', 'subscription.HomeMakerId')
                ->where('subscription.SubEndDate','>=', $dt->format('Y-m-d')." 00:00:00")
                ->where('subscription.TiffinSeekerId', $userId->TSId)->get();

            return response()->json($data, 200);

        } catch (Exception $e) {
            response()->json(['status' => 'amit_suks'], 203);
        }
    }
    public function tiffinseekersubscriberviewmonthly(Request $request)
    {

        try {

            $authid = \Auth::user()->id;
            $users  = User::find($authid);

            #dd($users);

            $userId = TiffinSeeker::where('UserId', $authid)->first();
            #dd($userId->HMId);

            $dt              = \Carbon\Carbon::now();
            $next_month_date = $dt->addDays(30);
#dd($dt->date);
            $data = User::join('tiffinseeker', 'tiffinseeker.UserId', '=', 'users.id')
                ->join('subscription', 'subscription.TiffinSeekerId', '=', 'tiffinseeker.TSid')
                ->join('homemakerpackages', 'homemakerpackages.HMPId', '=', 'subscription.HMPid')
                ->join('homemaker', 'homemaker.HMId', '=', 'subscription.HomeMakerId')
                ->whereBetween('subscription.SubEndDate', [$dt->format('Y-m-d')." 00:00:00", $dt->addDays(30)->format('Y-m-d')." 23:59:59"])
                ->where('subscription.TiffinSeekerId', $userId->TSId)->get();

            return response()->json($data, 200);

        } catch (Exception $e) {
            response()->json(['status' => 'amit_suks'], 203);
        }

    }*/

    public function tiffinseekersubscribtionview()
    {
        try {

            $authid = \Auth::user()->id;
            $users  = User::find($authid);
//dd($authid);
            $userId = TiffinSeeker::where('UserId', $authid)->first();
         //   dd($userId);

            $data = \DB::table('users as u1')
                ->leftJoin('homemaker', 'homemaker.UserId', '=', 'u1.id')   
                ->leftJoin('subscription', 'subscription.HomeMakerId', '=', 'homemaker.HMId')
                ->leftJoin('tiffinseeker', 'tiffinseeker.TSId', '=', 'subscription.TiffinSeekerId')  
                ->leftJoin('homemakerpackages', 'homemakerpackages.HMPId', '=', 'subscription.HMPid')        
                ->leftJoin('users as u2', 'u2.id', '=', 'tiffinseeker.UserId')
                ->leftJoin('payment', 'payment.SubscID', '=', 'subscription.SubId')
                ->select('u2.id as TiffinSeekerUserId', 'u2.email as TiffinSeekerEmail', 'u2.isEmailVerified as TiffinSeekerisEmailVerified', 'u2.isActive as TiffinSeekerisActive', 'u2.UserFname as TiffinSeekerUserFname', 'u2.UserLname as TiffinSeekerUserLname', 'u2.UserType as TiffinSeekerUserType', 'u2.UserPhone as TiffinSeekerUserPhone', 'u2.UserStreet as TiffinSeekerUserStreet', 'u2.UserCountry as TiffinSeekerUserCountry', 'u2.UserProvince as TiffinSeekerUserProvince', 'u2.UserCity as TiffinSeekerUserCity', 'u2.UserZipCode as TiffinSeekerUserZipCode', 'u2.UserCompanyName as TiffinSeekerUserCompanyName', 'u2.isBlocked as TiffinSeekerisBlocked', 'u1.*','subscription.*','payment.*','homemaker.*','tiffinseeker.*','homemakerpackages.*')
                ->where('subscription.TiffinSeekerId', $userId->TSId)->orderBy('subscription.created_at', 'desc')
                ->get();
              //  dd($userId->TSId);  




            if($data->count() > 0){

                foreach ($data as $record) {

                $driver = User::join('driver_users', 'driver_users.driverUserIdFk', '=', 'users.id')->where("paymentIdFk",$record->PId)->first();


                $personal_ratings = Reviews::where("HomeMakerID", $record->HMId)
                ->where("TiffinSeekerId", $record->TiffinSeekerId)->first();




                $record->driverName = $driver->UserFname." ".$driver->UserLname;
                $record->driverPhone = $driver->UserPhone;
                $record->driverUniqueCode = $driver->id;

          

                if($personal_ratings== null){
                    $record->personalRating = 0.0;
                }
                else{
                    $record->personalRating = $personal_ratings->ReviewCount;
                }

                   
                }
            }

            return response()->json($data, 200);

        } catch (Exception $e) {
            response()->json(['status' => 'amit_suks'], 203);
        }
    }


    public function hmViewSubscriptionDetails(Request $request)
    {

        try {

            $hm_sub_id = request('SubId');


                 $data = \DB::table('users as u1')
                ->leftJoin('homemaker', 'homemaker.UserId', '=', 'u1.id')   
                ->leftJoin('subscription', 'subscription.HomeMakerId', '=', 'homemaker.HMId')
                ->leftJoin('tiffinseeker', 'tiffinseeker.TSId', '=', 'subscription.TiffinSeekerId')  
                ->leftJoin('homemakerpackages', 'homemakerpackages.HMPId', '=', 'subscription.HMPid')        
                ->leftJoin('users as u2', 'u2.id', '=', 'tiffinseeker.UserId')
                ->leftJoin('payment', 'payment.SubscID', '=', 'subscription.SubId')
                ->select('u2.id as TiffinSeekerUserId', 'u2.email as TiffinSeekerEmail', 'u2.isEmailVerified as TiffinSeekerisEmailVerified', 'u2.isActive as TiffinSeekerisActive', 'u2.UserFname as TiffinSeekerUserFname', 'u2.UserLname as TiffinSeekerUserLname', 'u2.UserType as TiffinSeekerUserType', 'u2.UserPhone as TiffinSeekerUserPhone', 'u2.UserStreet as TiffinSeekerUserStreet', 'u2.UserCountry as TiffinSeekerUserCountry', 'u2.UserProvince as TiffinSeekerUserProvince', 'u2.UserCity as TiffinSeekerUserCity', 'u2.UserZipCode as TiffinSeekerUserZipCode', 'u2.UserCompanyName as TiffinSeekerUserCompanyName', 'u2.isBlocked as TiffinSeekerisBlocked', 'u1.*','subscription.*','payment.*','homemaker.*','tiffinseeker.*','homemakerpackages.*')
                ->where('subscription.SubId', $hm_sub_id)->orderBy('subscription.created_at', 'desc')
                ->get();

          return response()->json($data, 200);


            
        } catch (Exception $e) {

            response()->json(['status' => 'failed'], 203);

            
        }
                




    }

}

