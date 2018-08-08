<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    /*
      |--------------------------------------------------------------------------
      | Login Controller
      |--------------------------------------------------------------------------
      |
      | This controller handles authenticating users for the application and
      | redirecting them to your home screen. The controller uses a trait
      | to conveniently provide its functionality to your applications.
      |
     */

    protected $loginType;

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    //手机或者邮箱登录
    public function username()
    {
        return $this->loginType;
    }

    public function login(Request $request)
    {
        $username = $request->username;
        filter_var($username, FILTER_VALIDATE_EMAIL) ? $this->loginType = 'email' : $this->loginType = 'phone';
        $this->validateLogin($request);
        //判断邮箱是否激活
        if ($this->loginType == 'email' && !$this->emailIsActivated($request->username)) {
            return redirect()->route('login')->with('danger', '邮箱不存在或者未激活');
        }
        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        if ($this->attemptLogin($request)) {
            return $this->sendLoginResponse($request);
        }

        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }

    protected function emailIsActivated($email)
    {
        if (User::where('email', $email)->first()) {
            return User::where('email', $email)->first()->is_activated;
        }
        return false;
    }

    protected function validateLogin(Request $request)
    {
        $rules = ['password' => 'required|string'];
        if ($this->username() == 'email') {
            $rules['username'] = 'required|email';
        } else {
            //手机
            $rules['username'] = 'required|regex:/^1[34578]\d{9}$/';
        }
        $this->validate($request, $rules);
    }

    protected function credentials(Request $request)
    {
        $credentials = $request->only('password');
        $credentials[$this->username()] = $request->username;
        return $credentials;
    }

    protected function sendFailedLoginResponse(Request $request)
    {
        throw ValidationException::withMessages([
            'username' => [trans('auth.failed')],
        ]);
    }

}
