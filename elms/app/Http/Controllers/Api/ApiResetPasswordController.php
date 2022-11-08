<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use Illuminate\Foundation\Auth\ResetsPasswords;

class ApiResetPasswordController extends Controller
{

    public function guard()
    {
        return Auth::guard('api');
    }
    protected function broker()
    {
        return Password::broker('emitters'); //set password broker name according to guard which you have set in config/auth.php
    }

    public function resetForm(Request $request)
    {
        $token = $request->token;
        return view('auth.api.reset',compact('token'));
    }
    
    public function reset() {
        $credentials = request()->validate([
            'email' => 'required|email',
            'token' => 'required|string',
            'password' => 'required|string|confirmed'
        ]);

        $reset_password_status = Password::reset($credentials, function ($user, $password) {
            $user->password = $password;
            $user->save();
        });

        if ($reset_password_status == Password::INVALID_TOKEN) {
            return response()->json(["msg" => "Invalid token provided"], 400);
        }

        return response()->json(["msg" => "Password has been successfully changed"]);
    }

}
