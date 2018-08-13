<?php

namespace App\Models;

use Cache;
use Illuminate\Database\Eloquent\Model;

class Link extends Model
{

    public static $recommended_cache_key = 'hot_recommended_links';
    public static $recommended_size = 5;
    public static $view_size = 5;
    public static $view_cache_key = 'hot_view_links';
    protected static $cache_expire_in_minutes = 1440;

    public static function getRecommendedCached()
    {
        // 尝试从缓存中取出 cache_key 对应的数据。如果能取到，便直接返回数据。
        // 否则运行匿名函数中的代码来取出 links 表中所有的数据，返回的同时做了缓存。
        return Cache::remember(static::$recommended_cache_key, static::$cache_expire_in_minutes, function() {
                    return Article::recommended()->take(static::$recommended_size)->get();
                });
    }

    public static function forgetRecommendedCached()
    {
        Cache::forget(static::$recommended_cache_key);
    }

    public static function getViewCached()
    {
        // 尝试从缓存中取出 cache_key 对应的数据。如果能取到，便直接返回数据。
        // 否则运行匿名函数中的代码来取出 links 表中所有的数据，返回的同时做了缓存。
        return Cache::remember(static::$view_cache_key, static::$cache_expire_in_minutes, function() {
                    return Article::orderBy('view_count', 'desc')->take(static::$view_size)->get();
                });
    }

    public static function forgetViewCached()
    {
        Cache::forget(static::$view_cache_key);
    }

}
