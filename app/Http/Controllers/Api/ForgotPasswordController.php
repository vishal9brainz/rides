<?php

namespace App\Http\Controllers\Api;
use App\Http\Requests\ForgotPasswordRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Auth;
use App\User;
use App\Http\Controllers\Controller;

class ForgotPasswordController extends Controller
{
    public function sendEmail(ForgotPasswordRequest $request)
    {
        $user=User::where('email',$request->email)->first();
        $token = app('auth.password.broker')->createToken($user);
        $url='http://samp.ca/rides/password/reset/'.$token;
    	mail($request->email,'Reset Password Link',$url);
        return response()->json([
        	'success'		=>true,
        	'Message'		=>'Mail Sent SuccessFully',
        ]);
    }
    public function broker()
    {
        return Password::broker();
    }
}
