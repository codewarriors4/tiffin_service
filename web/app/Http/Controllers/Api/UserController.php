<?php

namespace TiffinService\Http\Controllers\Api;

use Illuminate\Http\Request;
use TiffinService\Http\Controllers\Controller;
use TiffinService\User;
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

    public function storeFCMToken(Request $request){

         $check_if_token_exists = UserMobInfo::where('userID',\Auth::user()->id)->where('fcmToken',request('fcmToken'))->get();

         if($check_if_token_exists->count() == 0){
             $store = new UserMobInfo();
         $store->fcmToken = request('fcmToken');
         $store->userID = \Auth::user()->id;

         $store->save();

         return response()->json(['status' => 'success'], 200);

         }
         else{

            return response()->json(['status' => 'success'], 200);

         }

        



    }

    public function userApproveFCMNotify(Request $request){

        


    }
}
