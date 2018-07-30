<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{

    protected $fillable = [
        'title', 'content', 'content_html', 'excerpt', 'page_image', 'slug', 'is_draft',
        'reply_count', 'view_count', 'last_reply_user_id', 'order', 'category_id',
        'deleted_at', 'published_at',
    ];
    protected $dates = ['deleted_at','published_at'];

    public function author()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

}
