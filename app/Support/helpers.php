<?php
/**
 * Created by PhpStorm.
 * User: hejl
 * Date: 2017/4/24
 * Time: 下午4:22
 */

if(!function_exists('authuser')){
    function authuser($driver = null){
        if($driver){
            return app('auth')->guard($driver)->user();
        }

        return app('auth')->user();
    }
}