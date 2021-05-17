<?php
/**
 * Created by PhpStorm.
 * User: hejl
 * Date: 2017/4/24
 * Time: 上午10:41
 */

namespace App\Http\Repositories;


use App\Comment;

class CommentRepository
{
    public function createComment(array $attr){
        return Comment::create($attr);
    }

}