<?php
/**
 * Created by PhpStorm.
 * User: hejl
 * Date: 2017/4/20
 * Time: 下午1:49
 */

namespace App\Channels;


use Illuminate\Notifications\Notification;

class SendcloudChannel
{
    public function send($notifiable,Notification $notification){
        $message = $notification->toSendCloud($notifiable);
    }

}