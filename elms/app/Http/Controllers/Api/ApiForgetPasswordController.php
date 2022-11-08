<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;

class ApiForgetPasswordController extends Controller
{
    use SendsPasswordResetEmails;

    public function guard()
    {
        return Auth::guard('api');
    }
    protected function broker()
    {
        return Password::broker('emitters'); //set password broker name according to guard which you have set in config/auth.php
    }

    protected function sendResetLinkResponse(Request $request, $response)
    {

        return response()->json(['status' => trans($response)], 200);
    }

    protected function sendResetLinkFailedResponse(Request $request, $response)
    {

        return response()->json(['status' => trans($response)], 422);
    }
    

    
}
