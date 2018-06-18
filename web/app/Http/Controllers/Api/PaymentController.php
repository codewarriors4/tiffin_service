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
        $expiration_year = request('expiration_year');
        $expiration_month = request('expiration_month');
        $cvc = request('cvc');
        $cvc = request('total_amount');
        $dt = Carbon::now();
      

          if($dt->year > $expiration_year){

             return response()->json(['error'=>'the year must be greater than current year'],203);


          }

         if($dt->year == $expiration_year && $dt->month > $expiration_month){

             return response()->json(['error'=>'please check the card expiry month'],203);


          }

        return response()->json(['status'=>'success'],203);

      


 	}

}
