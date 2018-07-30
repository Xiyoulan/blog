<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Overtrue\EasySms\EasySms;
use App\Http\Requests\PhoneRegisterRequest;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;

class RegisterController extends Controller
{
    /*
      |--------------------------------------------------------------------------
      | Register Controller
      |--------------------------------------------------------------------------
      |
      | This controller handles the registration of new users as well as their
      | validation and creation. By default this controller uses a trait to
      | provide this functionality without requiring any additional code.
      |
     */

use RegistersUsers;

    /**
     * Where to redirect users after registration.
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
        $this->middleware('guest');
        $this->middleware('throttle:1')->only('sendVerificationCode');
    }

    public function sendVerificationCode(PhoneRegisterRequest $request, EasySms $easySms)
    {
        $phone = $request->phone;
        if (!app()->environment('production')) {
            $code = '1234';
        } else {
            //随机生成4位数,左侧补零
            $code = str_pad(random_int(1, 9999), 4, 0, STR_PAD_LEFT);
            try {
                $result = $easySms->send($phone, [
                    'content' => "【Xiyoulan】您的验证码是{$code}。如非本人操作，请忽略本短信",
                ]);
            } catch (\Overtrue\EasySms\Exceptions\NoGatewayAvailableException $exception) {
                $message = $exception->getException('yunpian')->getMessage();
                return response()->json(['message' => $message ? "$message" : "短信发送异常",], 500);
            }
        }
        $data = ['phone' => $phone, 'code' => $code];
        session()->put('phone_verification', $data);
        return response()->json(['message' => '短信已发送!请留意您的手机'], 201);
    }

    public function append()
    {
        if (!session('phone_verification')) {
            return abort(404);
        }
        return view('auth.append');
    }

    public function registerWithPhone(Request $request)
    {
        $verificationCode = $request->verificationCode;
        $phone = $request->phone;
        $data = session()->get('phone_verification');
        if ($data['phone'] != $phone) {
            session()->forget('phone_verification');
            return back()->with('danger', '手机号码有误!');
        }
        if ($data['code'] != $verificationCode) {
            session()->forget('phone_verification');
            return back()->with('danger', '手机号码和验证码不匹配!');
        }
        return redirect()->route('append');
    }

    public function supplement(PhoneRegisterRequest $request)
    {
//        Validator::make($request->all(), [
//            'name' => 'required|string|max:25|unique:users',
//            'password' => 'required|string|min:6|confirmed',
//        ])->validate();
        event(new Registered($user = $this->createUser($request)));
        session()->forget('phone_verification');
        $this->guard()->login($user);
        return $this->registered($request, $user) ?: redirect($this->redirectPath());
    }

    protected function createUser($request)
    {
        $phone = session('phone_verification')['phone'];
        return User::create([
                    'name' => $request->name,
                    'password' => bcrypt($request->password),
                    'phone' => $phone,
        ]);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
                    'name' => 'required|string|max:25|unique:users',
                    'email' => 'required|string|email|max:255|unique:users',
                    'password' => 'required|string|min:6|confirmed',
                    'captcha' => 'required|captcha',
                        ], [
                    'captcha.required' => '验证码不能为空 o(╯□╰)o',
                    'captcha.captcha' => '验证码错误 o(╯□╰)o'
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        return User::create([
                    'name' => $data['name'],
                    'email' => $data['email'],
                    'password' => bcrypt($data['password']),
        ]);
    }

}
