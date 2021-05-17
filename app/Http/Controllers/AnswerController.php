<?php

namespace App\Http\Controllers;

use App\Http\Repositories\AnswerRepository;
use App\Http\Requests\StoreAnswerRequest;
use Illuminate\Support\Facades\Auth;

class AnswerController extends Controller
{
    private $answerRepository;
    public function __construct(AnswerRepository $answerRepository)
    {
        $this->answerRepository = $answerRepository;
    }

    public function store(StoreAnswerRequest $storeAnswerRequest , $question_id){
        $attr = [
            'body' => $storeAnswerRequest->body,
            'user_id'=>Auth::id(),
            'question_id'=>$question_id,
        ];
        $answer = $this->answerRepository->createAnswer($attr);
        $answer->question->increment('answer_count');
        $answer->user->increment('answer_count');
        return back();
    }
}
