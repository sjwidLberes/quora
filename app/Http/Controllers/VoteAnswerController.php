<?php

namespace App\Http\Controllers;

use App\Http\Repositories\AnswerRepository;
use Auth;

class VoteAnswerController extends Controller
{
    protected $answerRepository;

    /**
     * VoteAnswerController constructor.
     * @param $answerRepository
     */
    public function __construct(AnswerRepository $answerRepository)
    {
        $this->answerRepository = $answerRepository;
    }

    public function isVotedAnswer($answer_id){
        $vote = 0;
        if(Auth::check()){
            $vote = authuser('api')->vote_answers()->where('answer_id',$answer_id)->count();
        }

        if($vote !== 0){
            return response()->json(['voted'=>true]);
        }
        return response()->json(['voted'=>false]);
    }

    public function voteAnswer($answer_id){
        $answer = $this->answerRepository->byId($answer_id);
        $user = authuser('api');
        $voted = $user->vote_answers()->toggle($answer_id);
        if(count($voted['detached'])){
            $answer->decrement('vote_count');
            return response()->json(['voted'=>false]);
        }
        $answer->increment('vote_count');
        return response()->json(['voted'=>true]);
    }

}
