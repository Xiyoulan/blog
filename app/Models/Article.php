<?php

namespace App\Models;

class Article extends Model
{

    protected $fillable = [
        'title', 'content', 'content_html', 'page_image', 'slug', 'is_draft',
        'category_id', 'deleted_at',
    ];
    protected $dates = ['deleted_at', 'published_at'];

    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function replies()
    {
        return $this->hasMany(Reply::class, 'article_id');
    }

    public function lastReplyUser()
    {
        return $this->belongsTo(User::class, 'last_reply_user_id');
    }

    public function replyLog()
    {
        return $this->hasOne(ReplyLog::class, 'article_id', 'id');
    }

    public function isAuthor($user_id)
    {
        return $user_id == $this->user_id;
    }

    public function scopeRecentReplied($query)
    {
        // 当话题有新回复时，我们将编写逻辑来更新话题模型的 reply_count 属性，
        // 此时会自动触发框架对数据模型 updated_at 时间戳的更新
        return $query->orderBy('updated_at', 'desc');
    }

    public function scopeNoReply($query)
    {
        return $query->where('reply_count', 0)->recent();
    }

    public function scopeWithOrder($query, $order)
    {
        switch ($order) {
            case 'recent':
                $query->recent();
                break;
            case 'no-reply':
                $query->noReply();
                break;
            default:
                $query->recentReplied();
                break;
        }
    }

}
