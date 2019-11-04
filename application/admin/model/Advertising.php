<?php
/**
 * Created by PhpStorm.
 * User: 老王专用
 * Date: 2019/5/31
 * Time: 21:26
 */

namespace app\admin\model;


use think\Model;

class Advertising extends Model
{
    public function image(){
        return $this->belongsTo('Image','img_id','id');
    }
}