<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{

    protected $fillable = ['content',];

    public function replyTo()
    {
        return $this->belongsTo(User::class, 'to');
    }

    public function replyFrom()
    {
        return $this->belongsTo(User::class, 'from');
    }

}
