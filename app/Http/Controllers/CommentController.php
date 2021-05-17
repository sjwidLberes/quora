<?php

namespace App\Http\Controllers;

use App\Http\Repositories\AnswerRepository;
use App\Http\Repositories\CommentRepository;
use App\Http\Repositories\QuestionRepository;

class CommentController extends Controller
{
    protected $answerRepository;
    protected $questionRepository;
    protected $commentRepository;

    /**
     * CommentController constructor.
     * @param $answerRepository
     * @param $questionRepository
     * @param $commentRepository
     */
    public function __construct(AnswerRepository $answerRepository,QuestionRepository $questionRepository,CommentRepository $commentRepository)
    {
        $this->answerRepository = $answerRepository;
        $this->questionRepository = $questionRepository;
        $this->commentRepository = $commentRepository;
    }

    public function answerComments($answer_id){
        $answer= $this->answerRepository->getCommentsById($answer_id);
        return $answer->comments;
    }

    public function questionComments($question_id){
        $question = $this->questionRepository->getCommentsById($question_id);
        return $question->comments;
    }
    public function store(){
        $type = request('commentable_type') === 'question' ? 'App\Question' : 'App\Answer' ;
        $attr = [
            'user_id' => authuser('api')->id,
            'body' => request('body'),
            'commentable_type' => $type,
            'commentable_id' => request('commentable_id'),
        ];
        $comment = $this->commentRepository->createComment($attr);
        $comment->commentable->increment('comment_count');
        return $comment;
    }
}
