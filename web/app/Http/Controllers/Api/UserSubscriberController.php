<?php
namespace TiffinService\Http\Controllers\Api;
use Illuminate\Http\Request;
use TiffinService\HomeMaker;
use TiffinService\Http\Controllers\Controller;
use TiffinService\TiffinSeeker;
use TiffinService\User;
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
                ->where('subscription.HomeMakerId', $userId->HMId)->get();
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
            $next_month_date = $dt->addDays(30);
//dd($next_month_date);
            $data = User::join('tiffinseeker', 'tiffinseeker.UserId', '=', 'users.id')
                ->join('subscription', 'subscription.TiffinSeekerId', '=', 'tiffinseeker.TSid')
                ->join('homemakerpackages', 'homemakerpackages.HMPId', '=', 'subscription.HMPid')
                ->join('homemaker', 'homemaker.HMId', '=', 'subscription.HomeMakerId')
                ->whereBetween('subscription.SubEndDate', [$dt->format('Y-m-d')." 00:00:00", $dt->addDays(30)->format('Y-m-d')." 23:59:59"])
                ->where('subscription.HomeMakerId', $userId->HMId)->get();
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
            dd($authid);
            #dd($users);
            $userId = HomeMaker::where('UserId', $authid)->first();
            #dd($userId->HMId);
#dd($dt->date);
            $data = User::join('tiffinseeker', 'tiffinseeker.UserId', '=', 'users.id')
                ->join('subscription', 'subscription.TiffinSeekerId', '=', 'tiffinseeker.TSid')
                ->join('homemakerpackages', 'homemakerpackages.HMPId', '=', 'subscription.HMPid')
                ->join('homemaker', 'homemaker.HMId', '=', 'subscription.HomeMakerId')
                ->where('subscription.HomeMakerId', $userId->HMId)->get();
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
            $data = User::join('tiffinseeker', 'tiffinseeker.UserId', '=', 'users.id')
                ->join('subscription', 'subscription.TiffinSeekerId', '=', 'tiffinseeker.TSid')
                ->join('homemakerpackages', 'homemakerpackages.HMPId', '=', 'subscription.HMPid')
                ->join('homemaker', 'homemaker.HMId', '=', 'subscription.HomeMakerId')
                ->where('subscription.TiffinSeekerId', $userId->TSId)->get();
            return response()->json($data, 200);
        } catch (Exception $e) {
            response()->json(['status' => 'amit_suks'], 203);
        }
    }
}