<?php
/**
 * Created by PhpStorm.
 * User: hejl
 * Date: 2017/6/5
 * Time: 下午2:45
 */

namespace App\Http\Transformers;

use App\Hosttype;
use League\Fractal\TransformerAbstract;

class HostContentTransformer extends TransformerAbstract
{
    public function transform(Hosttype $hosttype){
        return [
            'id'=> $hosttype->id,
            'title' =>   $hosttype->title,
            'content'=>  $hosttype->hosts,
        ];
    }
}