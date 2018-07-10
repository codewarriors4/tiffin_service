<?php

namespace TiffinService\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */

        public function index()
    {
        //dd('zxczxczxc');

         if(\Auth::check()){
           // dd('yes');
            \Auth::logout();
         }     

      
         return redirect('/resetdone');
        

       // return view('home');
    }

   public function showloginform()
    {
       // return view('tsadmin.adminloginform');
    }






}
