<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Hosttype extends Model
{
    protected $table = 'host_types';
    public function hosts(){
        return $this->hasMany('App\Host','host_type_id','id');
    }
}
