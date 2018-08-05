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
    public function replies(){
        return $this->hasMany(Reply::class,'article_id');
    }
    public function lastReplyUser()
    {
        return $this->belongsTo(User::class, 'last_reply_user_id');
    }

    public function isAuthor($user_id)
    {
        return $user_id == $this->user_id;
    }
}
