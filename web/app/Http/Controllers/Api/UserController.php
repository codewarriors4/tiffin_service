<?php

namespace TiffinService\Http\Controllers\Api;

use Illuminate\Http\Request;
use TiffinService\HomeMaker;
use TiffinService\HomeMakerPackages;
use TiffinService\Http\Controllers\Controller;
use TiffinService\Reviews;
use TiffinService\Subscription;
use TiffinService\User;
use TiffinService\UserFCMSettings;
use TiffinService\UserMobInfo;

class UserController extends Controller
{

    public function tiffinSeekerViewHomeMaker(Request $request, $userId)
    {

        // var_dump("asdadasdadasd");

        try {

            $user = User::join('homemaker', 'users.id', '=', 'homemaker.UserId')->where('id', $userId)->first();
            return response()->json(['hmdetails' => $user], 200);

        } catch (Exception $e) {

            return response()->json(['status' => 'failed'], 203);

        }

    }

    public function storeFCMToken(Request $request)
    {

        $check_if_token_exists = UserMobInfo::where('userID', \Auth::user()->id)->where('fcmToken', request('fcmToken'))->get();

        if ($check_if_token_exists->count() == 0) {
            $store           = new UserMobInfo();
            $store->fcmToken = request('fcmToken');
            $store->userID   = \Auth::user()->id;

            $store->save();

            return response()->json(['status' => 'success'], 200);

        } else {

            return response()->json(['status' => 'success'], 200);

        }

    }

    public function userApproveFCMNotify(Request $request)
    {

    }

    public function getHomeMakerStats(Request $request)
    {

        try {

            $dt = \Carbon\Carbon::now();

            $userId = HomeMaker::where('UserId', \Auth::user()->id)->first();

            $subscription_count = Subscription::where('subscription.HomeMakerId', $userId->HMId)
                ->where('subscription.SubEndDate', '>=', $dt->format('Y-m-d') . " 00:00:00")
                ->count();

            $dt = \Carbon\Carbon::now();

            $recent_subscription_count = Subscription::where('subscription.HomeMakerId', $userId->HMId)
                ->whereBetween('subscription.created_at', [$dt->subDays(7)->format('Y-m-d') . " 23:59:59", $dt->addDays(8)->format('Y-m-d') . " 23:59:59"])->count();

            $total_reviews = Reviews::where('review.HomeMakerID', $userId->HMId)->count();

            $total_no_packages = HomeMakerPackages::where('homemakerpackages.HomeMakerId', $userId->HMId)->count();

            $response = array("total_active_subscribers" => $subscription_count, "recent_subscription_count" => $recent_subscription_count, "total_reviews" => $total_reviews, "total_no_packages" => $total_no_packages);

            return response()->json($response, 200);

        } catch (Exception $e) {

            return response()->json(['status' => 'failed'], 203);

        }

    }

    public function getUserFCMSettings(Request $request)
    {
        $userid = \Auth::user()->id;

        try {

            $fcm_settings = UserFCMSettings::join('masterfcmsettings', 'masterfcmsettings.MFCMSId', '=', 'UserFCMSettings.MFCMSIdFk')->where('UserIdFk', $userid)->get();

            return response()->json($fcm_settings, 200);

        } catch (Exception $e) {

            return response()->json(['status' => 'failed'], 203);

        }

    }

    public function storeUserFCMSettings(Request $request)
    {

        $userid = \Auth::user()->id;


        $MFCMSId  = request("MFCMSIdFk");
        $status   = request("status");
      //  $UserIdFk = request("UserIdFk");

        //$array1 = array("MFCMSId" => 1, "status" => 1, "UserIdFk" => $userid);
        //$array2 = array("MFCMSId" => 2, "status" => 1, "UserIdFk" => $userid);

        //  $final_array = array(0=>$array1,1 => $array2);

        try {

            $check_if_exists = UserFCMSettings::where("UserIdFk", $userid)->where("MFCMSIdFk", $MFCMSId)->get();

            if ($check_if_exists->count() > 0) {
                //update
                $update = UserFCMSettings::where("UserIdFk", $userid)->where("MFCMSIdFk", $MFCMSId)->update(['status' => $status]);

            } else {
                //create new record
                $fcm_setting = new UserFCMSettings;

                $fcm_setting->MFCMSIdFk = $MFCMSId;
                $fcm_setting->UserIdFk  = $userid;
                $fcm_setting->status    = $status;
                $fcm_setting->save();

            }

            return response()->json(['status' => 'success'], 200);

        } catch (Exception $e) {

            return response()->json(['status' => 'failed'], 203);

        }

    }

}
