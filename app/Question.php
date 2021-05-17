<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $fillable = ['title','body','user_id'];
    public function topics(){
        return $this->belongsToMany(Topic::class)->withTimestamps();
    }
    public function answers(){
        return $this->hasMany(Answer::class);
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function scopeIsShow($query){
        $query->where('is_hidden','F');
    }
    public function followed_users(){
        return $this->belongsToMany(User::class,'questions_followers')->withTimestamps();
    }
    public function comments(){
        return $this->morphMany(Comment::class,'commentable');
    }
}
