<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HostType extends Model
{
    public function hosts(){
        return $this->hasMany('App\Host');
    }
}
