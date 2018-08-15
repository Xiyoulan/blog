<?php

namespace App\Models\Traits;

use Cache;
use App\Models\Tag;
use DB;

trait HotTagsHelper
{

    protected static $tag_num = 25;
    //缓存相关配置
    protected static $cache_key = 'app_hot_tags';
    protected static $cache_expire_in_minutes = 125;

    public static function getHotTags()
    {
        // 尝试从缓存中取出 cache_key 对应的数据。如果能取到，便直接返回数据。
        // 否则运行匿名函数中的代码来取出活跃用户数据，返回的同时做了缓存。
        return Cache::remember(static::$cache_key, static::$cache_expire_in_minutes, function() {
                    return static::calculateHotTags();
                });
    }

    //计算热门tag
    public static function calculateHotTags()
    {
        //"select t.name,count(p.tag_id) as tag_count from tags as t inner join  article_tag_pivot as p on t.id = p.tag_id group by p.tag_id order by tag_count,desc  ";
        $hotTags =Tag::select(DB::raw(' tags.name,count(p.tag_id) as tag_count'))
                ->join('article_tag_pivot as p', 'tags.id', '=', 'p.tag_id')
                ->groupBy('p.tag_id')
                ->orderBy('tag_count', 'desc')
                ->take(static::$tag_num)
                ->get();
        return $hotTags;
    }
   public static function calculateAndCacheHotTags(){
      $hotTags = static::calculateHotTags();
      Cache::put(static::$cache_key,$hotTags,static::$cache_expire_in_minutes);
   }
}
