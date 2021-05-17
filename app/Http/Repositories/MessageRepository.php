<?php
/**
 * Created by PhpStorm.
 * User: hejl
 * Date: 2017/4/21
 * Time: 下午2:44
 */

namespace App\Http\Repositories;
use App\Message;


class MessageRepository
{
    public function create(array $attr){
        return Message::create($attr);
    }

    public function byDialogId($dialog_id){
        return Message::where('dialog_id',$dialog_id)->latest()->get();
    }

    public function byUserId($to_user_id,$from_user_id){
        return Message::where([
           ['to_user_id', $to_user_id], ['from_user_id',$from_user_id]
        ])->orWhere([
            ['to_user_id', $from_user_id], ['from_user_id',$to_user_id]
        ])->first();
    }

}