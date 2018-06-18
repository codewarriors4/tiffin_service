<?php

namespace TiffinService\Http\Controllers;

use Illuminate\Http\Request;

class SuccessController extends Controller
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
    

        public function resetdone()
    {
       
        dd('asdasdasd');

        //return view('home');
    }

    
}
