<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\Http\Requests\ResetPasswordRequest;
use App\Handlers\ImageUploadHandler;
use App\Notifications\ConfirmEmail;
use App\Models\User;

class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth', ['only' => ['update', 'reserPassword']]);
        $this->middleware('throttle:10,1440', ['only' => 'resendConfirmEmail']);
    }

    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    public function update(UserRequest $request, ImageUploadHandler $uploader, User $user)
    {
        $this->authorize('update', $user);
        $data = $request->except('email', 'name');
        if ($request->avatar) {
            //上传头像
            $result = $uploader->save($request->avatar, 'avatars', $user->id, 200);
            if ($result) {
                $data['avatar'] = $result['path'];
            }
        }
        $user->update($data);
        return redirect()->route('users.show', [$user->id, 'tab' => 'edit'])->with('success', '个人资料更新成功!');
    }

    public function resetPassword(ResetPasswordRequest $request, User $user)
    {
        $this->authorize('update', $user);
        $credentials['password'] = $request->oldPassword;
        if ($user->email) {
            $credentials['email'] = $user->email;
        }
        if ($user->phone) {
            $credentials['phone'] = $user->phone;
        }
        if (\Auth::guard()->attempt($credentials)) {
            $user->password = bcrypt($request->password);
            $user->save();
            \Auth::guard()->logout();
            return redirect()->route('login')->with('success', '密码修改成功,请重新登录!');
        }
        return redirect()->route('users.show', [$user->id, 'tab' => 'edit'])->withErrors('密码错误,重置密码失败!');
    }

    public function active(Request $request, User $user)
    {
        if ($user->is_activated) {
            return back()->with('warning', '该邮箱已经激活,请不要重复操作!');
        }
        if ($request->token) {
            $data = \DB::table('email_activates')->where('email', $user->email)->orderBy('created_at', 'desc')->first();
            if (!$data) {
                abort(404);
            }
            if ($request->token == $data->token) {
                $user->is_activated = true;
                $user->save();
                \DB::table('email_activates')->where('email', $user->email)->delete();
                return redirect()->route('login')->with(['username' => $user->email, 'info' => '邮箱激活成功,请重新登录!']);
            }
            return back()->with('danger', '无效的链接');
        }
        return view('auth.active', compact('user'));
    }

    public function resendConfirmEmail(Request $request, User $user)
    {
        $user->notify(new ConfirmEmail());
        return back()->with('info', '邮件已发送,请耐心等待!');
    }

    public function atwho()
    {
        $followings = \Auth::User()->followings()->pluck('name')->toArray();
        return response()->json($followings);
    }

}
