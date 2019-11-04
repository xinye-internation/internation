<?php
/**
 * Created by PhpStorm.
 * User: 老王专用
 * Date: 2019/6/1
 * Time: 16:40
 */

namespace app\admin\model;


use think\Model;

class Practice extends Model
{
    public function user(){
        return $this->belongsTo('User','user_id','id');
    }
    public function getWeekPractice(){

    }
}