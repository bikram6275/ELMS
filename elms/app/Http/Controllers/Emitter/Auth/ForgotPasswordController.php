<?php

namespace App\Http\Controllers\Emitter\Auth;

use App\Http\Controllers\Controller;
use App\Models\Emitter;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use DB;
use Carbon\Carbon;
use Mail;
use Hash;
class ForgotPasswordController extends Controller
{
    public function showForgetPasswordForm()
    {
      return view('emitter.password.forgot_password');
    }

    public function submitForgetPasswordForm(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:emitters',
        ]);

        $token = Str::random(64);

        DB::table('password_resets')->insert([
            'email' => $request->email,
            'token' => $token,
            'created_at' => Carbon::now()
          ]);

        Mail::send('emitter.password.email', ['token' => $token,'email'=>$request->email], function($message) use($request){
            $message->to($request->email);
            $message->subject('Reset Password');
        });

        return back()->with('message', 'We have e-mailed your password reset link!');
    }

    public function showResetPasswordForm($token,$email) {
        return view('emitter.password.forgetPasswordLink', ['token' => $token,'email'=>$email]);
     }

     public function submitResetPasswordForm(Request $request)
     {
         $request->validate([
             'email' => 'required|email|exists:emitters',
             'password' => 'required|string|min:6|confirmed',
             'password_confirmation' => 'required'
         ]);

         $updatePassword = DB::table('password_resets')
                             ->where([
                               'email' => $request->email,
                               'token' => $request->token
                             ])
                             ->first();
         if(!$updatePassword){
             return back()->withInput()->with('error', 'Invalid token!');
         }

         $user = Emitter::where('email', $request->email)
                     ->update(['password' => Hash::make($request->password)]);

         DB::table('password_resets')->where(['email'=> $request->email])->delete();
         return redirect('/emitters/login')->with('message', 'Your password has been changed!');
     }


}
