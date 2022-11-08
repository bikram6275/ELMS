<?php

namespace App\Http\Controllers\Emitter\Auth;

use App\Http\Controllers\Controller;
use App\Models\Logs\LoginFails;
use App\Models\Logs\LoginLogs;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Emitter;


class LoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */

    protected $redirectTo = '/emitter/dashboard';

    public function __construct()
    {
        $this->middleware('guest:emitter')->except('logout');
    }

    public function guard()
    {
        return Auth::guard('emitter');
    }

    public function showLoginForm()
    {

        return view('emitter.login',[

        ]);
    }

    public function login(Request $request)
    {

        $this->validateLogin($request);
        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);
            return $this->sendLockoutResponse($request);
        }else{
            if ($this->attemptLogin($request)) {
                return $this->sendLoginResponse($request);
            }
            // If the login attempt was unsuccessful we will increment the number of attempts
            // to login and redirect the user back to the login form. Of course, when this
            // user surpasses their maximum number of attempts they will get locked out.
            $this->incrementLoginAttempts($request);

            return $this->sendFailedLoginResponse($request);
        }
    }

    protected function validateLogin(Request $request)
    {
        $request->validate([
            $this->username() => 'required|string',
            'password' => 'required|string',
        ]);
    }

    public function logout()
    {
        Auth::guard('emitter')->logout();
        return redirect()->to('emitters/login');
    }

    protected function sendLoginResponse(Request $request)
    {
        $request->session()->regenerate();

        $this->clearLoginAttempts($request);

        $now = Carbon::now();
        $ip = \Request::ip();
        $agent = $request->header('User-Agent');
        LoginLogs::create(['user_id' => $this->guard()->user()->id, 'log_in_ip' => $ip, 'log_in_device' => $agent, 'log_in_date' => $now]);
        $user = $this->guard()->user();
        if ($user->account_approval == 'N') {
            return redirect()->route('emitter.edit',$user->id);
        }
        return $this->authenticated($request, $this->guard()->user())
            ?: redirect()->intended($this->redirectPath());
    }

    /**
     * @param Request $request
     * @return $this|\Illuminate\Http\JsonResponse
     */
    protected function sendFailedLoginResponse(Request $request)
    {
        $errors = [$this->username() => trans('auth.failed')];

        // Load user from database
        $user = Emitter::where($this->username(), $request->{$this->username()})->first();

        $ip = \Request::ip();
        $agent = $request->header('User-Agent');

        LoginFails::create(['user_name' => $request->get('email'), 'fail_password' => $request->get('password'), 'log_in_ip' => $ip, 'log_in_device' => $agent]);

        // Check if user was successfully loaded, that the password matches
        // and active is not 1. If so, override the default error message.
        if ($user && \Hash::check($request->password, $user->password) && $user->user_status != 'active') {
            $errors = [$this->username() => trans('auth.notActivated')];
        }

        if ($request->expectsJson()) {
            return response()->json($errors, 422);
        }
        return redirect()->back()
            ->withInput($request->only($this->username(), 'remember'))
            ->withErrors($errors);
    }





}
