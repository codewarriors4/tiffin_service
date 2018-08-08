<?php

namespace TiffinService\Http\Controllers\Api;

use Illuminate\Http\Request;
use TiffinService\HomeMaker;
use TiffinService\HomeMakerPackages;
use TiffinService\Http\Controllers\Controller;
use TiffinService\User;

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

            if ($request->hasFile('HMPImage')) {

                #$dir=.$request->user()->id;
                $request->file('HMPImage')->storeAs('public/upload/' . $request->user()->id . '/packages/' . $new_pkg_id, 'productimage' . '.' . $request->file('HMPImage')->getClientOriginalExtension());

                $image = 'productimage.' . $request->file('HMPImage')->getClientOriginalExtension();

                $homemaker = HomeMakerPackages::where('HMPId', $new_pkg_id)->update(['HMPImage' => $image]);

            }

           // $this->sendFCMOnPackageCreate($home_maker);

            

            return response()->json(['status' => 'success'], 200);

        } catch (\Exception $e) {

        //    dd($e);

            //   return response()->json(['status' => 'successsss'], 203);

            return response()->json($e->errors(), 203);

        }

    }


    public function sendFCMOnPackageCreate($homemakerid)
    {

        $subs_notify      = \Config::get('constants.options.new_package_created');
        $send_push_notifn = 0; // 0:send notify 1: dont send

        $fcmtokens = UserMobInfo::where('userID', $user_id)->select("fcmtoken")->get();

        $device_token_array = array();


         $subs = User::join('tiffinseeker', 'tiffinseeker.UserId', '=', 'users.id')
                ->join('subscription', 'subscription.TiffinSeekerId', '=', 'tiffinseeker.TSid')
                ->join('homemakerpackages', 'homemakerpackages.HMPId', '=', 'subscription.HMPid')
                ->join('homemaker', 'homemaker.HMId', '=', 'subscription.HomeMakerId')
                ->where('subscription.HomeMakerId', $homemakerid)->orderBy('subscription.created_at', 'desc')->get();


        if($subs->count()>0){
            foreach ($subs as $key => $sub) {
                

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
                    
              $image_file =    \Storage::get('public/upload/'.$home_maker_packages->id.'/packages/'.$homemaker_package_id.'/'.$home_maker_packages->HMPImage);        



            $home_maker_packages->prod_encoded_img = base64_encode($image_file);
        //    dd($home_maker_packages->prod_encoded_img);
            $home_maker_packages->hst   =number_format((float)(0.02 * $home_maker_packages->HMPCost), 2, '.', '') ;
            $total = $home_maker_packages->hst + $home_maker_packages->HMPCost;
            $home_maker_packages->total = number_format((float)$total, 2, '.', '');

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
