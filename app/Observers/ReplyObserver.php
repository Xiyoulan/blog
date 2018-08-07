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

        if ($reply->parent_id == 0) {
            // $num = \DB::table('replies')->where('parent_id', $reply->id)->delete();
            $reply->childReplies()->delete();
        }
        if ($reply->article->reply_count > 0) {
            $reply->article->decrement('reply_count');
        } else {
            $reply->article->reply_count = 0;
            $reply->article->save();
        }
        if ($reply->replyFrom->reply_count > 0) {
            $reply->replyFrom->decrement('reply_count');
        } else {
            $reply->replyFrom->reply_count = 0;
            $reply->replyFrom->save();
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
        //回复的人回复数+1
        $reply->ReplyFrom->increment('reply_count');

        $notification = new ArticleReplied($reply);
        //通知的人
        $user_arr = [];
        //通知作者
        $user_arr[] = $article->author;
        //如果存在被回复的人
        if ($reply->to) {
            $user_arr[] = $reply->replyTo;
        }
        //通知层主
        if ($reply->parent_id) {
            $user_arr[] = $reply->layer->replyFrom;
        }
        //去重
        $user_arr = array_unique($user_arr);
        foreach ($user_arr as $user) {
            $user->notify($notification);
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
