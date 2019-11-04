<?php
/**
 * Created by PhpStorm.
 * User: 老王专用
 * Date: 2019/5/30
 * Time: 15:33
 */

namespace app\admin\model;


use think\Model;

class Driver extends Model
{
    public function image(){
        return $this->belongsToMany('Image','driver_image','img_id','driver_id');
    }
    public function getDriverPhotos($id){
        $all = self::with('image')
            ->where('id','=',$id)
            ->find()
            ->toArray();
        return $all;
    }
}