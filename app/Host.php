<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Host extends Model
{
    protected $fillable = ['host_type_id','record'];
    public function hosttype(){
        return $this->belongsTo('App\Hosttype','host_type_id','id');
    }
}