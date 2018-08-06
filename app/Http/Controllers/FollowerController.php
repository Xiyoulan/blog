<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class FollowerController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function follow(User $user)
    {
        $current_user = \Auth::user();
        if ($current_user->canFollow($user->id)) {
            $current_user->follow($user->id);
            return back()->with('success', '关注成功!');
        }
        return back()->with('warning', '关注失败!');
    }

    public function unfollow(User $user)
    {
        $current_user = \Auth::user();
        if (!$current_user->isNotMyself($user->id)) {
            return back()->with('warning', '不能关注或者取消关注自己!');
        }
        if ($current_user->isFollowing($user->id)) {
            $current_user->unfollow($user->id);
            return back()->with('success', '取消关注成功!');
        }
        return back()->with('warning', '取消关注失败!');
    }

}
