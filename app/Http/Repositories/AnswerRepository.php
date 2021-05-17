<?php
/**
 * Created by PhpStorm.
 * User: hejl
 * Date: 2017/4/18
 * Time: 上午1:03
 */

namespace App\Http\Repositories;


use App\Answer;

class AnswerRepository
{
    public function createAnswer(array $attr){
        return Answer::create($attr);
    }
    public function byId($id){
        return Answer::find($id);
    }

    public function getCommentsById($answer_id){
        return Answer::with('comments','comments.user')->where('id',$answer_id)->first();
    }

}