<?php

namespace App\Models;

class Reply extends Model
{

    //protected $touches = ['article'];

    protected $fillable = ['content',];

    public function replyTo()
    {
        return $this->belongsTo(User::class, 'to');
    }

    public function replyFrom()
    {
        return $this->belongsTo(User::class, 'from');
    }

    public function article()
    {
        return $this->belongsTo(Article::class);
    }

    //层
    public function layer()
    {
        return $this->belongsTo(Reply::class, 'parent_id');
    }

    public function setParentNode($reply_id)
    {
        $parentReply = Reply::where('parent_id', 0)->find($reply_id);
        if ($parentReply) {
            $this->parent_id = $reply_id;
        }
        $this->parent_id = 0;
    }

    public function childReplies()
    {
        return $this->hasMany(Reply::class, 'parent_id');
    }

    public function scopeParentNode($query)
    {
        return $query->where('parent_id', 0);
    }

    public function scopeChildNode($query)
    {
        return $query->where('parent_id', '<>', 0);
    }

    //定位
//    public function location()
//    {
////        $page = ceil(100/config('application.replies_per_page'));
////        if ($this->parent_id) {
////        return route('articles.show', [$this->article_id,'page'=>$page]) . "#reply" . $this->parent_id;
////        } else {
////            return route('articles.show', [$this->article_id,'page'=>$page]) . "#reply" . $this->id;
////        }
//    }

}
