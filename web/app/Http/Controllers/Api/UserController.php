<?php

namespace TiffinService\Http\Controllers\Api;

use Illuminate\Http\Request;
use TiffinService\Http\Controllers\Controller;
use TiffinService\User;

class UserController extends Controller
{

    public function tiffinSeekerViewHomeMaker(Request $request, $userId)
    {

        var_dump("asdadasdadasd");

        try {

            $user = User::join('homemaker', 'users.id', '=', 'homemaker.UserId')->where('id', $userId)->get();
            return response()->json(['hmdetails' => $user], 200);

        } catch (Exception $e) {

            return response()->json(['status' => 'failed'], 203);

        }

    }
}
