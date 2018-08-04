<?php

namespace TiffinService\Http\Controllers;

use Illuminate\Http\Request;
use TiffinService\User;
use TiffinService\UserMobInfo;

use TiffinService\UserFCMSettings;



class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */

    public function showloginform()
    {
        return view('tsadmin.adminloginform');
    }

    public function authenticateAdmin(Request $request)
    {
        $username = $request->input('email');

        $password = $request->input('password');
        if (\Auth::attempt(['email' => $username, 'password' => $password])) {
            $Is_Admin = \Auth::user()->UserType;

            if ($Is_Admin == 2) {

                return redirect()->route('manageusers');

            } else {
                \Auth::logout();
                return redirect()->route('adminloginget')->withInput()->withErrors("You are not Authorised");
            }
        } else {
            return redirect()->route('adminloginget')->withInput()->withErrors("You are not Authorised");

        }

    }

    public function approveUser($id)
    {    
    

        $user_id = $id;

       $status = User::where('id', $user_id)->update(['isActive' => 1]);

        $user_details          = User::join('homemaker', 'homemaker.UserId', '=', 'users.id')->where('users.id', $user_id)->first();
        $subs_notify = \Config::get('constants.options.New_susbcriber_notify');
        $send_push_notifn      = 0; // 0:send notify 1: dont send


        $fcmtokens = UserMobInfo::where('userID', $user_id)->select("fcmtoken")->get();

        $device_token_array = array();

        $getfcmsettings = UserFCMSettings::where("UserIdFk", $user_details->id)->where("MFCMSIdFk", $subs_notify)->select("status")->first();


        if($getfcmsettings == null){
            $send_push_notifn = 0;
        }
        else if($getfcmsettings->status == 0){
            $send_push_notifn = 0;
        }
        else{
            $send_push_notifn = 1;
        }

        if ($fcmtokens->count() > 0 && $send_push_notifn == 0) {

            foreach ($fcmtokens as $key => $token) {
                array_push($device_token_array, $token->fcmtoken);
            }

            $title   = "Approved!! Congrats Chef " . $user_details->UserFname;
            $body    = "Hey Chef, " . $user_details->UserFname . " <" . $user_details->email . "> " . "you are open for business. Start preparing your menu";
            $feedbck = \PushNotification::setService('fcm')
                ->setMessage([
                    'notification' => [
                        'title' => $title,
                        'body'  => $body,
                        'sound' => 'default',
                    ],
                    'data'         => [
                        'extraPayLoad1' => 'value1',
                        'extraPayLoad2' => 'value2',
                    ],
                ])
                ->setApiKey('AAAAoeIud7w:APA91bGsANVi6YE_HfJOODY6nwnBVCLWMx4Suinb6tux6R6jePDA-qX2mpNcGanlEQusyqnZ1PaZjFePkDDla6PUxgF1KZVm3WTPdbq7wYGfY9LPidiHEPCbTtQFT89bDMs5GotOb63cNYll-RG1Kd7OFJE47T1I7w')
                ->setDevicesToken($device_token_array)
                ->send()
                ->getFeedback();

        }

         return redirect()->route('manageusers');
    

    }

    public function updateUser(Request $request)
    {

    }

}
