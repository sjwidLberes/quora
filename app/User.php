<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name', 'email', 'password','avatar','active_token','api_token','setting'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'setting' => 'array',
    ];

    public function owns(Model $model){
        return $this->id == $model->user_id ;
    }

    public function questions(){
        return $this->hasMany(Question::class);
    }

    public function answers(){
        return $this->hasMany(Answer::class);
    }
    public function following_questions(){
        return $this->belongsToMany(Question::class,'questions_followers')->withTimestamps();
    }

    //用户所有的粉丝
    public function followers(){
        return $this->belongsToMany(self::class,'followers','follower_id','followed_id')->withTimestamps();
    }

    //用户所有关注的人
    public function followings(){
        return $this->belongsToMany(self::class,'followers','followed_id','follower_id')->withTimestamps();
    }

    //用户点赞的所有答案
    public function vote_answers(){
        return $this->belongsToMany(Answer::class,'users_answers_vote')->withTimestamps();
    }

    //用户发出的所有信息
    public function to_messages(){
        return $this->hasMany(Message::class,'to_user_id');
    }

    //用户收到的所有信息
    public function from_messages(){
        return $this->hasMany(Message::class,'from_user_id');
    }
}
