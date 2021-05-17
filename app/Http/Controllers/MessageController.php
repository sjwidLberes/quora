<?php

namespace App\Http\Controllers;

use App\Http\Repositories\MessageRepository;
use App\Notifications\UserMessageNotification;
use Auth;

class MessageController extends Controller
{
    protected $messageRepository;

    /**
     * MessageController constructor.
     * @param $messageRepository
     */
    public function __construct(MessageRepository $messageRepository)
    {
        $this->messageRepository = $messageRepository;
        $this->middleware('auth');
    }


    //使用VUE组件发送消息
    public function sendMessage(){
        $exist_message = $this->messageRepository->byUserId(request('user_id'),authuser('api')->id);
        if($exist_message != null){
            $dialog_id = $exist_message->dialog_id;
        }else{
            $dialog_id = time().Auth::id();
        }
        $attr = [
                'to_user_id' => request('user_id'),
                'from_user_id' => authuser('api')->id,
                'body'=> request('body'),
                'dialog_id'=> $dialog_id,
            ];
        $new_message = $this->messageRepository->create($attr);
        $new_message->to_user->notify(new UserMessageNotification($new_message));
        if($new_message){
            return response()->json(['status'=>true]);
        }
        return response()->json(['status'=>false]);
    }

    //对话列表发送消息
    public function storeDialog($dialog_id){
        $message = $this->messageRepository->byDialogId($dialog_id)->first();

        $to_user_id = authuser()->id === $message->from_user_id ? $message->to_user_id : $message->from_user_id ;
        $attr = [
            'to_user_id' => $to_user_id,
            'from_user_id' => authuser()->id,
            'body'=> request('body'),
            'dialog_id'=> $dialog_id,
        ];
        $new_message = $this->messageRepository->create($attr);
        $new_message->to_user->notify(new UserMessageNotification($new_message));
        return  redirect()->route('message.dialog',$dialog_id);
    }

    public function messageDialog($dialog_id){
        $messages = $this->messageRepository->byDialogId($dialog_id);
        return view('notify.inbox',compact('messages','dialog_id'));

    }
}
