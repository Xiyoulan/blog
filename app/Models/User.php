<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{

    use Notifiable {
        notify as protected laravelNotify;
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'phone', 'avatar', 'introduction'
    ];
    protected $casts = [
        'is_blocked' => 'boolean',
        'is_activated' => 'boolean',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function notify($instance)
    {
        // 如果要通知的人是当前用户，就不必通知了！
        if ($this->id == \Auth::id()) {
            return;
        }
        $this->increment('notification_count');
        $this->laravelNotify($instance);
    }

    public function articles()
    {
        return $this->hasMany(Article::class);
    }

    public function replies()
    {
        return $this->hasMany(Reply::class, 'from');
    }

    public function followers()
    {
        return $this->belongsToMany(User::class, 'followers', 'user_id', 'follower_id');
    }

    public function followings()
    {
        return $this->belongsToMany(User::class, 'followers', 'follower_id', 'user_id');
    }

    public function isFollowing($user_id)
    {
        return $this->followings->contains($user_id);
    }

    public function isNotMyself($user_id)
    {
        return $this->id !== $user_id;
    }

    public function canFollow($user_id)
    {
        if (!$this->isNotMyself($user_id)) {
            return false;
        }
        return !$this->isFollowing($user_id);
    }

    public function follow($user_ids)
    {
        if (!is_array($user_ids)) {
            $user_ids = compact('user_ids');
        }
        $this->followings()->sync($user_ids, false);
    }

    public function unFollow($user_ids)
    {
        if (!is_array($user_ids)) {
            $user_ids = compact('user_ids');
        }
        $this->followings()->detach($user_ids);
    }

    public function markAsRead()
    {
        $this->notification_count = 0;
        $this->save();
        $this->unreadNotifications->markAsRead();
    }

    public function getAvatarAttribute($value)
    {
        if (!$value) {
            // 默认头像
            return config('application.default_avatar');
        }
        if (starts_with($value, ['http://', 'https://'])) {
            return $value;
        }
        $url = $this->cleanUrl($value);
        if (starts_with($url, '/storage')) {
            return config('app.url') . $url;
        }
        return config('app.url') . '/storage' . $url;
    }

    private function cleanUrl($url)
    {
        return '/' . ltrim($url, '/');
    }

}
