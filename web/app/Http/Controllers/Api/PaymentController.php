<?php

namespace TiffinService\Http\Controllers\Api;

use TiffinService\Http\Requests\CreditCardRequest;
use Illuminate\Http\Request;
use TiffinService\HomeMaker;
use TiffinService\Http\Controllers\Controller;
use LVR\CreditCard\CardNumber;
use LVR\CreditCard\Cards\Visa;
use LVR\CreditCard\ExpirationDateValidator;
use TiffinService\Http\Requests\CardValidator;
use TiffinService\Payment;
use TiffinService\SubscribedPackages;
use TiffinService\Subscription;
use Illuminate\Mail\Mailer;
use Carbon\Carbon;

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

            return response()->json(['packages_array'=>$packages_array],200);

        } catch (Exception $e) {


        		    return response()->json(['status'=>'failed'],203);


        }

    }

     public function Payment(CardValidator $request) // shows the cart summary     
    {   

        try {

                $expiration_year = request('expiration_year');
                $homemaker_id = request('HomeMakerId');
                $expiration_month = request('expiration_month');
                $cvc = request('cvc');
                $cost = request('total_amount');
                $cart = request('cart');

           
                $dt = Carbon::now();

                $subscription_start_date = $dt;
                $subscription_end_date = Carbon::now()->addDays(30); 
                $substatus = 0;        

                  if($dt->year > $expiration_year){

                     return response()->json(['error'=>'the year must be greater than current year'],203);

                  }

                 if($dt->year == $expiration_year && $dt->month > $expiration_month){

                     return response()->json(['error'=>'please check the card expiry month'],203);

                  }

                  $subscription = new Subscription;
                  $subscription->SubCost = $cost;
                  $subscription->SubStartDate = $subscription_start_date;
                  $subscription->SubEndDate = $subscription_end_date;
                  $subscription->SubStatus = $substatus;
                  $subscription->TiffinSeekerId = \Auth::user()->id;
                  $subscription->HomeMakerId = $homemaker_id;
                  $subscription->save();
             
                  $payment = new Payment;

                  $payment->PAmt = $cost;
                  $payment->PStatus = '1';

                  $payment->SubscID = $subscription->SubId;
                  $payment->save();

                  Subscription::where('SubId',$subscription->SubId)->update(['SubStatus' => 1]);

                  if (count($cart) > 0) {

                    foreach ($cart as $key => $value) {

                        $add_package = new SubscribedPackages;
                        $add_package->PackageId = $value;
                        $add_package->SubscrpId = $subscription->SubId;
                        $add_package->save();
                    }

                  }

                  Mailer::to(\Auth::user()->email)->send()

                 return response()->json(['status'=>'success'],200); 
            
        } catch (Exception $e) {


             return response()->json(['status'=>'failed'],203); 
        }
           


 	}

}
