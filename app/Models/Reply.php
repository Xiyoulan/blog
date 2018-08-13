<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
class Reply extends Model
{
    use SoftDeletes;
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

    public function replyLog()
    {
        return $this->belongsTo(ReplyLog::class, 'article_id', 'article_id');
    }

    //层
    public function parentReply()
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

    public function link()
    {
        $deletedLayerNum=0;
        $currentLayer = $this->layer;
        if ($this->replyLog) {
            $deletedLayers = $this->replyLog->data['deleted_layer'];
            array_push($deletedLayers, $currentLayer);
            $arr = array_unique($deletedLayers);
            sort($arr);
            //得到回复前面被删除的楼层数目
            $deletedLayerNum = array_search($currentLayer, $deletedLayers);
        }
        //页码
        $page = ceil(($currentLayer - $deletedLayerNum) / config('application.replies_per_page'));
        if ($this->parent_id) {
            return route('articles.show', [$this->article_id, 'page' => $page]) . "#reply" . $this->parent_id;
        }
        return route('articles.show', [$this->article_id, 'page' => $page]) . "#reply" . $this->id;
    }

}
