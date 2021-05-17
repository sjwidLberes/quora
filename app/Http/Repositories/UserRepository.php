<?php
/**
 * Created by PhpStorm.
 * User: hejl
 * Date: 2017/4/20
 * Time: 上午10:54
 */

namespace App\Http\Repositories;

use App\User;

class UserRepository
{
    public function byId($id){
        return User::find($id);
    }

}