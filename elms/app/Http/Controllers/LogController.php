<?php

namespace App\Http\Controllers;

use App\Models\Logs\LoginLogs;
use App\Models\Logs\LoginFails;

class LogController extends Controller
{
    /**
     * @var LoginFails
     */
    private $loginFails;
    /**
     * @var LoginLogs
     */
    private $loginLogs;

    public function __construct(LoginFails $loginFails, LoginLogs $loginLogs)
    {
        
        $this->loginFails = $loginFails;
        $this->loginLogs = $loginLogs;
    }

    public function loginLogs()
    {
        $logins = $this->loginLogs->latest()->paginate(20);
        return view('backend.logs.login', compact('logins'));
    }

    public function failLogin()
    {
        $failLogins = $this->loginFails->latest()->paginate(20);
        return view('backend.logs.failLogin', compact('failLogins'));
    }
}
