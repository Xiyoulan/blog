<?php

namespace App\Observers;

use App\Models\Article;

// creating, created, updating, updated, saving,
// saved,  deleting, deleted, restoring, restored
class ArticleObserver
{

    public function deleted(Article $article)
    {
        //删除该话题下所有回复
        \DB::table('replies')->where('article_id',$article->id)->delete();
    }
    
//    public function created(Reply $reply){
//           
//    }
    public function saving(Article $article){
        $article->content_html = clean($article->content_html,'user_article_body');
    }
}

