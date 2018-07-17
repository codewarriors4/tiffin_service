<?php

namespace TiffinService\Http\Controllers\Api;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Mail\Mailer;
use TiffinService\HomeMaker;
use TiffinService\Http\Controllers\Controller;
use TiffinService\Http\Requests\CardValidator;
use TiffinService\User;
use TiffinService\UserMobInfo;
use TiffinService\Payment;
use TiffinService\Subscription;
use TiffinService\TiffinSeeker;

class PaymentController extends Controller
{

    /* public function AddToCart(Request $request){

    $count = \Cart::count();
    var_dump(\Auth::user()->id);

    //$request->session()->put('key1', 'value1');
    //$request->session()->put('key2', 'value2');

    //\Cart::restore('digvijay.yelve111@gmail.com');
    /*\Cart::restore('jaison.joseph26@gmail.com');

    \Cart::store('digvijay.yelve111@gmail.com');*/

    /*\Cart::instance('wishlist1')->add(2, 'Product 1', 1, 9.99);
    \Cart::instance('wishlist1')->add(4, 'Product 2', 1, 8.99);
    \Cart::instance('wishlist1')->add(5, 'Product 3', 1, 88.99);
    \Cart::instance('wishlist1')->add(6, 'Product 3', 1, 88.99);*/

    //    \Cart::store('digvijay.yelve111@gmail.com');
    //\Cart::store('jaison.joseph26@gmail.com');

    /*$cart_content = \Cart::instance('wishlist1')->content();

    var_dump($request->session()->all());
    var_dump($cart_content);*/

    //}*/

    //send sample response in JSON as below for the following method
    /*    {
    "cart":[
    {
    "package_id":2

    },
    {
    "package_id":3

    },
    {
    "package_id":40

    }
    ]
    }*/

    private $mailer;

    public function __construct(Mailer $mailer)
    {
        $this->mailer = $mailer;
    }

    public function CartSummary(Request $request) // shows the cart summary

    {

        $cart = request('cart');

        $packages_array = array();

        try {

            if (count($cart) > 0) {

                foreach ($cart as $key => $value) {

                    /*    $product = HomeMakerPackages::join('homemaker','homemaker.HMId','=','homemakerpackages.HomeMakerId')
                    ->join('homemaker','homemaker.UserId','=','users.id')->where('users.isActive',1)->where('HMPId',$value)->get()->toArray();*/
                    /*
                    $product = User::join('homemaker','homemaker.UserId','=','users.id')
                    ->join('homemaker','homemaker.HMId','=','homemakerpackages.HomeMakerId')->where('users.isActive',1)->where('HMPId',$value)->get()->toArray();*/

                    /*$product = User::find(62)->homemaker()->homemakerpackages()->where('users.isActive',1)->where('HMPId',$value)->get()->toArray();*/

                    $product = HomeMaker::join('users', 'users.id', '=', 'homemaker.UserId')
                        ->join('homemakerpackages', 'homemaker.HMId', '=', 'homemakerpackages.HomeMakerId')->where('isActive', 1)->where('HMPId', $value['package_id'])->get()->toArray();

                    /*           join('homemaker','homemaker.HMId','=','homemakerpackages.HomeMakerId')
                    ->join('homemaker','homemaker.UserId','=','users.id')->where('users.isActive',1)->where('HMPId',$value)->get()->toArray();*/

                    array_push($packages_array, $product);

                }

            }

            return response()->json(['packages_array' => $packages_array], 200);

        } catch (Exception $e) {

            return response()->json(['status' => 'failed'], 203);

        }

    }

    public function Payment(CardValidator $request) // shows the cart summary

    {

        try {

            $expiration_year  = "20" . request('expiration_year');
            $homemaker_id     = request('HomeMakerId');
            $expiration_month = request('expiration_month');
            $lastfourdig      = substr(request('card_number'), -4);
            $card_number      = 'XXXX-XXXX-XXXX-' . $lastfourdig;

            $cvc           = request('cvc');
            $cost          = request('subtotal');
            $hst           = request('hst');
            $total_cost    = request('total');
            $subsPackageId = request('HMPid');

            $dt = Carbon::now();

            $subscription_start_date = $dt;
            $subscription_end_date   = Carbon::now()->addDays(30);
            $substatus               = 0;

            if ($dt->year > $expiration_year) {

                return response()->json(['error' => 'the year must be greater or equal touch(filename) current year'], 203);

            }

            if ($dt->year == $expiration_year && $dt->month > $expiration_month) {

                return response()->json(['error' => 'please check the card expiry month'], 203);

            }

            $tsId = TiffinSeeker::where("UserId", \Auth::user()->id)->first();

            $subscription                 = new Subscription;
            $subscription->SubCost        = $total_cost;
            $subscription->SubStartDate   = $subscription_start_date;
            $subscription->SubEndDate     = $subscription_end_date;
            $subscription->SubStatus      = $substatus;
            $subscription->TiffinSeekerId = $tsId->TSId;
            $subscription->HomeMakerId    = $homemaker_id;
            $subscription->HMPid          = $subsPackageId;
            $subscription->save();

            $payment = new Payment;

            $payment->PAmt        = $total_cost;
            $payment->PTax        = $hst;
            $payment->PSubTotal   = $cost;
            $payment->PCardNumber = $card_number;

            $payment->PStatus = '1';

            $payment->SubscID = $subscription->SubId;
            $payment->save();

            Subscription::where('SubId', $subscription->SubId)->update(['SubStatus' => 1]);

            $user_details = User::join('homemaker', 'homemaker.UserId', '=', 'users.id')->where('homemaker.HMId', $homemaker_id)->first();



            $fcmtokens = UserMobInfo::where('userID', $user_details->id)->select("fcmtoken")->get();

            $device_token_array = array();



            if ($fcmtokens->count() > 0) {

                foreach ($fcmtokens as $key => $token) {
                    array_push($device_token_array, $token->fcmtoken);
                }

                $title   = "You have got a new Subscription ";
                $body    = \Auth::user()->UserFname." subscribed to one of your packages !";

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

               // dd($feedbck);

            }

            /*                if (count($cart) > 0) {

            foreach ($cart as $key => $value) {

            $add_package = new SubscribedPackages;
            $add_package->PackageId = $value;
            $add_package->SubscrpId = $subscription->SubId;
            $add_package->save();
            }

            }*/

            /*           Mail::to(\Auth::user()->email)->send();

            $message = "Payment complete";
            mail('\Auth::user()->email', 'Payment complete', $message);*/
            return response()->json(['status' => 'success'], 200);

        } catch (Exception $e) {

            return response()->json(['status' => 'failed'], 203);
        }

    }

}
