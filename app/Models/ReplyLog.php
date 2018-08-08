<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReplyLog extends Model
{

    protected $table = 'reply_log';
    //将data属性转化为数组
    protected $casts = [
        'data' => 'array'
    ];
    protected $fillable = ['article_id', 'data'];

}
