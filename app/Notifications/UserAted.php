<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use App\Models\Reply;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;

class UserAted extends Notification implements ShouldQueue
{

    use Queueable;

    public $reply;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Reply $reply)
    {
        $this->reply = $reply;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        $article = $this->reply->article;
        $data = [
            'reply_id' => $this->reply->id,
            'reply_content' => $this->reply->content,
            'from_id' => $this->reply->replyFrom->id,
            'from_name' => $this->reply->replyFrom->name,
            'from_avatar' => $this->reply->replyFrom->avatar,
            'article_id' => $article->id,
            'article_title' => $article->title,
        ];
        if ($this->reply->to) {
            $data['to_id'] = $this->reply->to;
            $data['to_name'] = $this->reply->replyTo->name;
            $data['to_avatar'] = $this->reply->replyTo->avatar;
        }
        return $data;
    }

}
