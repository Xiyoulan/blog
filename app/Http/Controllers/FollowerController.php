<?php

namespace App\Http\Controllers;

use http\Env\Response;
use Illuminate\Http\Request;
use App\Models\User;

class FollowerController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth',['only'=>['follow','unfollow']]);
    }

    public function follow(User $user)
    {
        $current_user = \Auth::user();
        if ($current_user->canFollow($user->id)) {
            $current_user->follow($user->id);
            $current_user->increment('following_count');
            $user->increment('follower_count');
            //return back()->with('success', '关注成功!');
            return response('success');
        }
        //return back()->with('warning', '关注失败!');
        return response('fail', 400);
    }

    public function unfollow(User $user)
    {
        $current_user = \Auth::user();
        if (!$current_user->isNotMyself($user->id)) {
            //return back()->with('warning', '不能关注或者取消关注自己!');
            return response('fail', 400);
        }
        if ($current_user->isFollowing($user->id)) {
            $current_user->unfollow($user->id);
            $current_user->decrement('following_count');
            $user->decrement('follower_count');
            //return back()->with('success', '取消关注成功!');
            return response('success');
        }
        //return back()->with('warning', '取消关注失败!');
        return response('fail', 400);
    }

    public function followers(User $user)
    {
        $users = $user->followers()->orderBy('followers.created_at', 'desc')->paginate(20);
        $action = 'followers';
        return view('users.follower', compact('user', 'users','action'));
    }

    public function followings(User $user)
    {
        $users = $user->followings()->orderBy('followers.created_at', 'desc')->paginate(20);
        $action = 'followings';
        return view('users.follower', compact('user', 'users','action'));
    }
}
