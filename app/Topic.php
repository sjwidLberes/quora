<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
    protected $fillable = ['title','question_count','bio'];
    public function questions(){
        return $this->belongsToMany(Question::class)->withTimestamps();
    }
}
