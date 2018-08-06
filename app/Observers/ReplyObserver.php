<?php

namespace App\Observers;

use App\Models\Reply;

// creating, created, updating, updated, saving,
// saved,  deleting, deleted, restoring, restored
class ReplyObserver
{

    public function deleted(Reply $reply)
    {
        $num = 0;
        if ($reply->parent_id == 0) {
            $num = \DB::table('replies')->where('parent_id', $reply->id)->delete();
        }
        if($reply->article->reply_count>$num+1){
           $reply->article->decrement('reply_count', $num + 1);
        }else{
            $reply->article->reply_count=0;
            $reply->article->save();
        }
     
    }

    public function creating(Reply $reply){
        if($reply->parent_id ==0 ){
            $reply->content = clean($reply->content,'user_article_body');
        }
    }
    public function created(Reply $reply)
    {
        $article = $reply->article;
        $article->last_reply_user_id = $reply->from;
        $article->reply_count += 1;
        $article->save();
    }

}
