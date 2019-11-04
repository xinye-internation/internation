<?php
/**
 * Created by PhpStorm.
 * User: 老王专用
 * Date: 2019/5/31
 * Time: 22:17
 */

namespace app\api\model;


class driver extends BaseModel
{
    protected $hidden = ['create_time','update_time','from','id'];
    public function image(){
        return $this->belongsToMany('Image','driver_image','img_id','driver_id');
    }
    public function getDriverList(){
        $all = self::with(['image'])
            ->select()
            ->toArray();
        return $all;
    }
    public function getDriverInformation($id){
        $driver = self::with(['image'])
            ->where('id','=',$id)
            ->find();
        return $driver;
    }
}