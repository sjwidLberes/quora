<?php

namespace App\Http\Transformers;
use App\task;
use League\Fractal\TransformerAbstract;

/**
 * Created by PhpStorm.
 * User: hejl
 * Date: 2017/5/31
 * Time: 下午4:59
 */
class TaskTransformer extends TransformerAbstract
{
    public function transform(task $task){
        return [
            'id' => $task->id,
            'title' =>   $task->title,
            'time' =>  $task->created_at->diffForHumans(),
            'completed' => (boolean)$task->completed
        ];
    }

}