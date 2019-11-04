<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
use think\Route;

Route::post("api/:v/token/user","api/:v.Token/getToken");

Route::get("api/:v/index","api/:v.Index/index");
Route::post("api/:v/signup","api/:v.Index/sign_up");
Route::get("api/:v/driver/:driver_id","api/:v.Index/driver");
Route::get("api/:v/discount","api/:v.Index/discount");

Route::get("api/:v/answer/count/:type","api/:v.Answer/getTiKuCount");


return [
    '__pattern__' => [
        'name' => '\w+',
    ],
    '[hello]'     => [
        ':id'   => ['index/hello', ['method' => 'get'], ['id' => '\d+']],
        ':name' => ['index/hello', ['method' => 'post']],
    ],

];
