<?php
/**
 * Created by PhpStorm.
 * User: hejl
 * Date: 2017/4/17
 * Time: 下午4:19
 */

namespace App\Http\Repositories;
use App\Question;
use App\Topic;


class QuestionRepository
{
    public function byIdWithTopics($id){
        return Question::where('id',$id)->with('topics')->first();
    }

    public function byId($id){
        return Question::find($id);
    }

    public function createQuestion(array $attr){
        return Question::create($attr);
    }

    public function getQuestionFeed(){
        return Question::with('user')->isShow()->latest('updated_at')->get();
    }

    public function normalizeTopics(array $topics){
        return collect($topics)->map(function ($topic){
            if(is_numeric($topic)){
                Topic::find($topic)->increment('question_count');
                return (int)$topic;
            }else{
                $newTopic = Topic::create([
                    'title' => $topic,
                    'question_count'=>1,
                ]);
                return $newTopic->id;
            }
        })->toArray();
    }

    public function getCommentsById($question_id){
        return Question::with('comments','comments.user')->where('id',$question_id)->first();
    }

}