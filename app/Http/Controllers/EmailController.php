<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Support\Facades\Auth;

class EmailController extends Controller
{
    public function active($token){
        $user = User::where('active_token',$token)->first();
        if(is_null($user)){
            flash('激活失败','danger');
            return redirect('/');
        }
        $user->is_active = 1;
        $user->active_token = str_random(40);
        $user->save();

        Auth::login($user);
        flash('激活成功','success');
        return redirect('/home');
    }
}
