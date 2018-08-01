<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class ConfirmEmail extends Notification implements ShouldQueue
{

    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $email =$notifiable->email;
        $token =$this->randomToken($email);
        $name = $notifiable->name;
        $appName = config('app.name');
        $url = route('active', [$notifiable->id, $token]);
        return (new MailMessage)
                        ->subject('新用户激活')
                        ->line("亲爱的 {$name}，恭喜你成功注册到 {$appName}，点击下面的激活用户按钮即可完成用户激活")
                        ->action('激活用户', $url)
                        ->line('感谢使用我们的应用,我们会一如既往为大家提供优质的内容和服务!')
                        ->line('如果这不是您本人的操作，请忽略此邮件。');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
                //
        ];
    }

    protected function randomToken($email)
    {
        //生成token
        $token = str_random(60);
        \DB::table('email_activates')->insert([
            'email' => $email,
            'token' => $token,
            'created_at' => \Carbon\Carbon::now(),
        ]);
        return $token;
    }
}
