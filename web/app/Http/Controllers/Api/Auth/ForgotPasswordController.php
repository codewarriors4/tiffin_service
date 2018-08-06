<?php

namespace TiffinService\Http\Controllers\Api\Auth;

use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use TiffinService\Http\Controllers\Controller;
use TiffinService\Transformers\Json;
use TiffinService\User;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
     */
    use SendsPasswordResetEmails;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('guest');
    }

    public function sendDriverResetLinkEmail(Request $request)
    {
        $this->validateEmail($request);

        // We will send the password reset link to this user. Once we have attempted
        // to send the link, we will examine the response then see the message we
        // need to show to the user. Finally, we'll send out a proper response.
        $response = $this->broker()->sendResetLink(
            $request->only('email')
        );

        $response == \Password::RESET_LINK_SENT
        ? $this->sendResetLinkResponse($response)
        : $this->sendResetLinkFailedResponse($request, $response);

}

public function showResetForm(Request $request, $token = null)
    {
    return view('auth.passwords.reset')->with(
        ['token' => $token, 'email' => $request->email]
    );
}
/**
 * Send a reset link to the given user.
 *
 * @param  \Illuminate\Http\Request  $request
 * @return \Illuminate\Http\Response
 */
public function getResetToken(Request $request)
    {
    $this->validate($request, ['email' => 'required|email']);
    if ($request->wantsJson()) {
        $user = User::where('email', $request->input('email'))->first();
        if (!$user) {
            return response()->json(Json::response(null, trans('passwords.user')), 400);
        }
        $token = $this->broker()->createToken($user);
        // return response()->json(Json::response(['token' => $token]));

        // We will send the password reset link to this user. Once we have attempted
        // to send the link, we will examine the response then see the message we
        // need to show to the user. Finally, we'll send out a proper response.
        $response = $this->broker()->sendResetLink(
            $request->only('email')
        );

        $response == \Password::RESET_LINK_SENT
        ? $this->sendResetLinkResponse($response)
        : $this->sendResetLinkFailedResponse($request, $response);

        if ($response == "passwords.sent") {

            $response1["error"]   = false;
            $response1["message"] = "reset link sent to email";

            return response()->json($response1);
        }

        $response1["error"]   = true;
        $response1["message"] = "user not found";

        return response()->json($response1);
    }
}

public function getResetTokenWeb(Request $request)
    {
    $this->validate($request, ['email' => 'required|email']);

    $user = User::where('email', $request->input('email'))->first();
    if (!$user) {
        return response()->json(Json::response(null, trans('passwords.user')), 400);
    }
    $token = $this->broker()->createToken($user);
    // return response()->json(Json::response(['token' => $token]));

    // We will send the password reset link to this user. Once we have attempted
    // to send the link, we will examine the response then see the message we
    // need to show to the user. Finally, we'll send out a proper response.
    $response = $this->broker()->sendResetLink(
        $request->only('email')
    );

    return "success";




}

public function sendResetLink(Request $request)
    {

}
}
