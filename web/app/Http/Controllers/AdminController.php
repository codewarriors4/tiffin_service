<?php

namespace TiffinService\Http\Controllers;

use Illuminate\Http\Request;

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

        $password  = $request->input('password');
        if(\Auth::attempt(['email'=>$username,'password'=>$password]))
        {   
            $Is_Admin = \Auth::user()->UserType;
 

            if($Is_Admin == 3)
            {
               
                return redirect()->route('manageusers');

            }
            else
            {
                Auth::logout();
                return redirect()->route('adminloginget')->withInput()->withErrors("You are not Authorised");
            }
        }

        else
        {  
            return redirect()->route('adminloginget')->withInput()->withErrors("You are not Authorised");

        }

    }




}
