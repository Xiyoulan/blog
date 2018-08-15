<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\HotTagsHelper;
class Tag extends Model
{
    use HotTagsHelper;
    protected $fillable =[
        'name','meta_description'
    ];
    public function articles(){
        return $this->belongsToMany(Article::class, 'article_tag_pivot', 'tag_id', 'article_id');
    }
    public static function addNeededTags(array $tags){
        if(count($tags) === 0){
            return;
        }
        //从数据库找出已存在的tag
        $found =static::whereIn('name',$tags)->pluck('name')->toArray();
        //创建不存在的tag
        foreach(array_diff($tags, $found) as $tag ){
           static::create([
                'name'=>$tag,
                'meta_description'=>'',
            ]);
        }
    }
}
