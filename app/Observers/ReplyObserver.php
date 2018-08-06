<?php

namespace App\Observers;

use App\Models\Reply;
use App\Notifications\ArticleReplied;
use App\Handlers\AtUserHandler;
use App\Notifications\UserAted;

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
        if ($reply->article->reply_count > $num + 1) {
            $reply->article->decrement('reply_count', $num + 1);
        } else {
            $reply->article->reply_count = 0;
            $reply->article->save();
        }
    }

    public function creating(Reply $reply)
    {

        $content = clean($reply->content, 'user_article_body');

        //查找@username 并替换成链接 
        $reply->content = app(AtUserHandler::class)->replaceAtUserNames($content);
        //通知被艾特的用户
        //1.获得被@的用户
        $users = app(AtUserHandler::class)->getAtUsers($content);
        if (!empty($users)) {
            session()->put('at_users', $users);
        }
    }

    public function created(Reply $reply)
    {
        $article = $reply->article;
        $article->last_reply_user_id = $reply->from;
        $article->reply_count += 1;
        $article->save();
        $notification = new ArticleReplied($reply);
        //通知作者
        $article->author->notify($notification);
        //如果存在被回复的人
        if ($reply->to) {
            $reply->replyTo->notify($notification);
        }
        //通知层主
        if ($reply->parent_id) {
            //如果层主和被回复的人相同,则不用重复通知
            if ($reply->to) {
                if ($reply->layer->replyFrom->id == $reply->replyTo->id) {
                    return;
                }
            }
            $reply->layer->replyFrom->notify($notification);
        }
        //通知被@的人
        $users = session()->get('at_users');
        if ($users) {
            foreach ($users as $user) {
                $user->notify(new UserAted($reply));
            }
            session()->forget('at_users');
        }
    }

}
