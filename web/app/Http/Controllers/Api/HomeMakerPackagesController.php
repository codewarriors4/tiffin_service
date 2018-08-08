<?php

namespace TiffinService\Http\Controllers\Api;

use Illuminate\Http\Request;
use TiffinService\HomeMaker;
use TiffinService\HomeMakerPackages;
use TiffinService\Http\Controllers\Controller;
use TiffinService\User;
use TiffinService\UserFCMSettings;
use TiffinService\UserMobInfo;



class HomeMakerPackagesController extends Controller
{

    public function HMPCreate(Request $request)
    {

        try {

            $user_id = \Auth::user()->id;

            //dd($user_id);

            $messages = array("HMPName.required" => "The Package name is required",
                "HMPDesc.required"                   => "The package description is required",
                "HMPCost.required"                   => "The package cost is required",
                "HMPCost.numeric"                    => "Please enter only numeric value for cost",
                "HMPImage.required"                  => "Please upload a pic for your menu",
                "HMPImage.image"                     => "Please upload only image files",
                "HMPImage.mimes"                     => "Please upload only image files of types jpg,jpeg,png",
            );

            $this->validate($request, [
                'HMPName'  => 'required',
                'HMPDesc'  => 'required',
                'HMPCost'  => 'required|numeric',
                'HMPImage' => 'required|mimes:jpg,jpeg,png',
            ], $messages);

            $home_maker = HomeMaker::where('UserId', $user_id)->first();

            $package_create = HomeMakerPackages::create([

                'HMPName'     => request('HMPName'),
                'HMPDesc'     => request('HMPDesc'),
                'HMPCost'     => request('HMPCost'),
                'HomeMakerId' => $home_maker->HMId,

            ]);
            $new_pkg_id = $package_create->HMPId;

            //  dd( $new_pkg_id);

            if ($request->hasFile('HMPImage')) {

                #$dir=.$request->user()->id;
                $request->file('HMPImage')->storeAs('public/upload/' . $request->user()->id . '/packages/' . $new_pkg_id, 'productimage' . '.' . $request->file('HMPImage')->getClientOriginalExtension());

                $image = 'productimage.' . $request->file('HMPImage')->getClientOriginalExtension();

                $homemaker = HomeMakerPackages::where('HMPId', $new_pkg_id)->update(['HMPImage' => $image]);

            }

            $this->sendFCMOnPackageCreate($home_maker);

            return response()->json(['status' => 'success'], 200);

        } catch (\Exception $e) {

            //    dd($e);

            //   return response()->json(['status' => 'successsss'], 203);

            // return response()->json($e->errors(), 203);

        }

    }

    public function sendFCMOnPackageCreate($homemaker)
    {
        $subs_notify      = \Config::get('constants.options.new_package_created');
        $send_push_notifn = 0; // 0:send notify 1: dont send

        $subs = \DB::table('users')
                ->leftJoin('tiffinseeker', 'tiffinseeker.UserId', '=', 'users.id')
                ->leftJoin('subscription', 'subscription.TiffinSeekerId', '=', 'tiffinseeker.TSid')
                ->leftJoin('homemakerpackages', 'homemakerpackages.HMPId', '=', 'subscription.HMPid')
                ->leftJoin('homemaker', 'homemaker.HMId', '=', 'subscription.HomeMakerId')
                ->where('subscription.HomeMakerId', $homemaker->HMId)->groupBy('name')->orderBy('subscription.created_at', 'desc')->get();  

/*        $subs = User::join('tiffinseeker', 'tiffinseeker.UserId', '=', 'users.id')
            ->join('subscription', 'subscription.TiffinSeekerId', '=', 'tiffinseeker.TSid')
            ->join('homemakerpackages', 'homemakerpackages.HMPId', '=', 'subscription.HMPid')
            ->join('homemaker', 'homemaker.HMId', '=', 'subscription.HomeMakerId')
            ->where('subscription.HomeMakerId', $homemaker->HMId)->select('users.id')->distinct()->orderBy('subscription.created_at', 'desc')->get();   */ 
            dd($subs);



        if ($subs->count() > 0) {

            foreach ($subs as $sub) {

                $fcmtokens          = UserMobInfo::where('userID', $sub->id)->select("fcmtoken")->get();
                $device_token_array = array();
                $getfcmsettings     = UserFCMSettings::where("UserIdFk", $sub->id)->where("MFCMSIdFk", $subs_notify)->select("status")->first();

                if ($getfcmsettings == null) {
                    $send_push_notifn = 0;
                } else if ($getfcmsettings->status == 0) {
                    $send_push_notifn = 0;
                } else {
                    $send_push_notifn = 1;
                }

                if ($fcmtokens->count() > 0 && $send_push_notifn == 0) {

                    foreach ($fcmtokens as $key => $token) {
                        array_push($device_token_array, $token->fcmtoken);
                    }



                    $title   = "New menu alert";
                    $body    = "Your Chef"." ".\Auth::user()->UserFname." "."added a new menu !!";
                    $feedbck = \PushNotification::setService('fcm')
                        ->setMessage([
                            'notification' => [
                                'title' => $title,
                                'body'  => $body,
                                'sound' => 'default',
                            ],
                            'data'         => [
                                'notificationtype' => 'new_package_created',
                                'extraPayLoad2' => 'value2',
                            ],
                        ])
                        ->setApiKey('AAAAoeIud7w:APA91bGsANVi6YE_HfJOODY6nwnBVCLWMx4Suinb6tux6R6jePDA-qX2mpNcGanlEQusyqnZ1PaZjFePkDDla6PUxgF1KZVm3WTPdbq7wYGfY9LPidiHEPCbTtQFT89bDMs5GotOb63cNYll-RG1Kd7OFJE47T1I7w')
                        ->setDevicesToken($device_token_array)
                        ->send()
                        ->getFeedback();

                }

            }
        }

    }

    public function HMPUpdate(Request $request)
    {

        try {

            $user_id = \Auth::user()->id;

            $homemaker_package_id = request('HMPId');

            $messages = array("HMPName.required" => "The Package name is required",
                "HMPDesc.required"                   => "The package description is required",
                "HMPCost.required"                   => "The package cost is required",
                "HMPCost.numeric"                    => "Please enter only numeric value for cost",
                "HMPImage.required"                  => "Please upload a pic for your menu",
                "HMPImage.image"                     => "Please upload only image files",
                "HMPImage.mimes"                     => "Please upload only image files of types jpg,jpeg,png",
            );

            $this->validate($request, [
                'HMPName'  => 'required',
                'HMPDesc'  => 'required',
                'HMPCost'  => 'required|numeric',
                'HMPImage' => 'required|mimes:jpg,jpeg,png',
            ], $messages);

            $package_update = HomeMakerPackages::where('HMPId', $homemaker_package_id)->update(['HMPName' => request('HMPName'), 'HMPDesc' => request('HMPDesc'), 'HMPCost' => request('HMPCost')]);

            if ($request->hasFile('HMPImage')) {

                #$dir=.$request->user()->id;
                $request->file('HMPImage')->storeAs('public/upload/' . $request->user()->id . '/packages/' . $homemaker_package_id, 'productimage' . '.' . $request->file('HMPImage')->getClientOriginalExtension());

                $image = 'productimage.' . $request->file('HMPImage')->getClientOriginalExtension();

                $homemaker = HomeMakerPackages::where('HMPId', $homemaker_package_id)->update(['HMPImage' => $image]);

                return response()->json(['status' => 'success'], 200);
            }

        } catch (\Exception $e) {
            return response()->json($e->errors(), 203);
        }

    }

    public function HMPDelete(Request $request)
    {

        try {

            $user_id = \Auth::user()->id;

            $home_maker = HomeMaker::where('UserId', $user_id)->firstOrFail();

            HomeMakerPackages::where('HomeMakerId', $home_maker->HMId)->where('HMPId', request('HMPId'))->delete();

            return response()->json(['status' => 'success'], 200);

        } catch (Exception $e) {

            return response()->json(['status' => 'failed'], 203);

        }

    }

    //Homekar View own packages
    public function HMPMyPackages(Request $request)
    {

        try {

            $user_id = \Auth::user()->id;

            $home_maker_packages = HomeMaker::join('users', 'users.id', '=', 'homemaker.UserId')
                ->join('homemakerpackages', 'homemaker.HMId', '=', 'homemakerpackages.HomeMakerId')->where('id', $user_id)->orderBy('homemakerpackages.created_at', 'desc')->get();

            return response()->json(['home_maker_packages' => $home_maker_packages], 200);

        } catch (Exception $e) {

            return response()->json(['status' => 'failed'], 203);

        }

    }

    //Homekar View a single package
    public function HMPMyPackage(Request $request)
    {

        try {

            //$user_id = \Auth::user()->id;
            $homemaker_package_id = request('HMPId');

            if ($homemaker_package_id == '' || $homemaker_package_id == null) {
                return response()->json(['status' => 'failed'], 203);
            }

            $home_maker_packages = User::join('homemaker', 'homemaker.UserId', '=', 'users.id')
                ->join('homemakerpackages', 'homemakerpackages.HomeMakerId', '=', 'homemaker.HMId')->where('HMPId', $homemaker_package_id)->first();
            //    dd($home_maker_packages);

            $image_file = \Storage::get('public/upload/' . $home_maker_packages->id . '/packages/' . $homemaker_package_id . '/' . $home_maker_packages->HMPImage);

            $home_maker_packages->prod_encoded_img = base64_encode($image_file);
            //    dd($home_maker_packages->prod_encoded_img);
            $home_maker_packages->hst   = number_format((float) (0.02 * $home_maker_packages->HMPCost), 2, '.', '');
            $total                      = $home_maker_packages->hst + $homess_maker_packages->HMPCost;
            $home_maker_packages->total = number_format((float) $total, 2, '.', '');

            return response()->json(['home_maker_packages' => $home_maker_packages], 200);

        } catch (Exception $e) {

            return response()->json(['status' => 'failed'], 203);

        }

    }

    //Tiffinseekers views a homemaker pakage

    public function HMPListings(Request $request)
    {

        try {

            $homemaker_id = request('HMId');

            $home_maker_packages = HomeMaker::join('homemakerpackages', 'homemaker.HMId', '=', 'homemakerpackages.HomeMakerId')->where('HMId', $homemaker_id)->orderBy('homemakerpackages.created_at', 'desc')->get();

            return response()->json(['home_maker_packages' => $home_maker_packages], 200);

        } catch (Exception $e) {

            return response()->json(['status' => 'failed'], 203);

        }

    }

}
