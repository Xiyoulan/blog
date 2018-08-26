<?php

namespace App\Models\Traits;

use Redis;
use Carbon\Carbon;

trait ArticleViewCountHepler
{

    //缓存相关
    protected $hash_prefix = 'app_article_view_count_';
    protected $field_prefix = 'article_';

    /**
     * 在redis缓存下view_count
     */
    public function addViewCount()
    {
        $date = Carbon::now()->toDateString();
        $hash = $this->getHashFromDateString($date);
        //字段名称:eg:article_1
        $field = $this->getHashField();
        //判断该字段的值是否存在,不存在则从数据库取得数据并存入redis中,逻辑已经在我们重写getViewCountAttribute()中
        $count = $this->view_count;
        // 数据写入 Redis ，字段已存在会被更新
        Redis::hSet($hash, $field, ++$count);
    }

    //同步昨日数据到数据库中
    public function syncViewCountOfYesterday()
    {    //获取前一天日期
        $date = Carbon::yesterday()->toDateString();
        $this->syncViewCountByDate($date);
    }

    public function syncViewCountNow()
    {
        //获取今天日期
        $date = Carbon::now()->toDateString();
        $this->syncViewCountByDate($date);
    }

    /**
     * @param $date 日期字符串
     */
    public function syncViewCountByDate($date)
    {
        // Redis 哈希表的命名，如：app_article_view_count_2017-1-1
        $hash = $this->getHashFromDateString($date);
        $datas = Redis::hGetAll($hash);
        foreach ($datas as $article_id => $view_count) {
            //去掉前缀 eg:user_1 => 1
            $article_id = str_replace($this->field_prefix, '', $article_id);
            $article = $this->find($article_id);
            if ($article) {
                $article->view_count = $view_count;
                $article->save();
            }
        }
        // 以数据库为中心的存储，既已同步，即可删除
        Redis::del($hash);
    }

    //
    public function getHashFromDateString($date)
    {
        // Redis 哈希表的命名，如：app_article_view_count_2017-1-1
        return $this->hash_prefix . $date;
    }

    public function getHashField()
    {
        // 字段名称，如：article_1
        return $this->field_prefix . $this->id;
    }

    //获得文章浏览次数
    public function getViewCountAttribute($value)
    {
        //若是在缓存中有从缓存中取,否则在数据库中取
        $date = Carbon::now()->toDateString();
        $hash = $this->getHashFromDateString($date);
        $field = $this->getHashField();
        $count = Redis::hGet($hash, $field) ?: $value;
        return $count;
    }

}