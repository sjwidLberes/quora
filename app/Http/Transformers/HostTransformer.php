<?php

namespace App\Http\Transformers;


use App\Hosttype;
use League\Fractal\TransformerAbstract;

/**
 * Created by PhpStorm.
 * User: hejl
 * Date: 2017/5/31
 * Time: 下午4:59
 */
class HostTransformer extends TransformerAbstract
{
    public function transform(Hosttype $hosttype){
        return [
            'id' => $hosttype->id,
            'title' =>   $hosttype->title,
        ];
    }

}