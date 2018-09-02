<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Traits\ArticleViewCountHepler;
use Laravel\Scout\Searchable;
use App\Models\Tag;
class Article extends Model
{
    use SoftDeletes,ArticleViewCountHepler,Searchable;

    public $timestamps = false;
    protected $casts = [
        'is_top' => 'boolean',
        'is_recommended' => 'boolean',
    ];
    protected $fillable = [
        'title', 'content', 'content_html', 'page_image', 'slug', 'is_draft',
        'category_id', 'deleted_at',
    ];
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

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

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'article_tag_pivot', 'article_id', 'tag_id');
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

    public function scopeTop($query)
    {
        return $query->orderBy('is_top', 'desc');
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

    public function scopeRecommended($query)
    {
        return $query->where('is_recommended', 1)->recentReplied();
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
            case 'recommended':
                $query->recommended();
                break;
            default:
                $query->recentReplied();
                break;
        }
    }

    public function getPageImageAttribute($value)
    {
        if (!$value) {
            return null;
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

    public function syncTags(array $tags)
    {
        Tag::addNeededTags($tags);

        if (count($tags)) {
            //同步中间表
            $this->tags()->sync(
                    Tag::whereIn('name', $tags)->pluck('id')->all()
            );
            return;
        }

        $this->tags()->detach();
    }

}
