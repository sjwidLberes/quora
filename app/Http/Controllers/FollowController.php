<?php

namespace App\Http\Controllers;

use App\Jobs\SendUserFollowPush;
use App\Events\UserFollowEvent;
use App\Http\Repositories\QuestionRepository;
use App\Http\Repositories\UserRepository;
use App\Notifications\NewUserFollowNotification;


class FollowController extends Controller
{
    protected $userRepository;
    public function __construct(UserRepository $userRepository,QuestionRepository $questionRepository)
    {
        $this->userRepository = $userRepository;
        $this->questionRepository = $questionRepository;
//        $this->middleware('auth');
    }

    public function isFollowedUser($user_id){
        $user = authuser('api');
        $follow = $user->followers()->where('followed_id',$user_id)->count();
        if($follow !== 0){
            return response()->json(['followed'=>true]);
        }
        return response()->json(['followed'=>false]);
    }

    public function followUser($user_id){
        $user = authuser('api');
        $user_followed = $this->userRepository->byId($user_id);//获取被关注的人
        $followed = $user->followings()->toggle($user_id);
        if(count($followed['detached'])){
            $user->decrement('following_count');
            $user_followed->decrement('follower_count');//被关注的人粉丝数量处理
            return response()->json(['followed'=>false]);
        }
        $user_followed->notify(new NewUserFollowNotification());
       // $this->dispatch(new SendUserFollowPush());
        $user->increment('following_count');
        $user_followed->increment('follower_count');
        return response()->json(['followed'=>true]);
    }

    public function isFollowedQuestion($question_id){
        $user = authuser('api');
        $follow = $user->following_questions()->where('question_id',$question_id)->count();
        if($follow !== 0){
            return response()->json(['followed'=>true]);
        }
        return response()->json(['followed'=>false]);
    }

    public function followQuestion($question_id){
        $user = authuser('api');
        $question = $this->questionRepository->byId($question_id);
        $followed = $question->followed_users()->toggle($user->id);
        if(count($followed['detached'])){
            $question->decrement('follower_count');
            $user->decrement('followquestion_count');
            return response()->json(['followed'=>false]);
        }
        $question->increment('follower_count');
        $user->increment('followquestion_count');
        return response()->json(['followed'=>true]);
    }

}
