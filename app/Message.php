<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = ['from_user_id','to_user_id','body','dialog_id','read_at'];

    public function to_user(){
        return $this->belongsTo(User::class,'to_user_id');
    }

    public function from_user(){
        return $this->belongsTo(User::class,'from_user_id');
    }
}
