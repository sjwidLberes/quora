<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Naux\Mail\SendCloudTemplate;
use Mail;
use Illuminate\Notifications\Messages\BroadcastMessage;

class NewUserFollowNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        //return ['database',SendcloudChannel::class];
        return ['database','broadcast'];
    }

    public function toDatabase($notifiable){
        return [
          'name' => authuser('api')->name,
        ];
    }

    public function toSendCloud($notifiable){
        $bind_data = [
            'url' => route('question.index'),
            'name' => authuser('api')->name,
        ];
        $template = new SendCloudTemplate('follow_notify', $bind_data);
        Mail::raw($template, function ($message) use ($notifiable) {
            $message->from('hejl@snail.com', 'Laravel');
            $message->to($notifiable->email);
        });
    }
    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([
            'name' => authuser('api')->name,
        ]);
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */


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
}
