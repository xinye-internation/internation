<?php
/**
 * Created by PhpStorm.
 * User: 老王专用
 * Date: 2019/6/1
 * Time: 11:45
 */

namespace app\api\model;


class Advertising extends BaseModel
{
    protected $hidden = ['img_id','create_time','update_time','delete_time'];
    public function image(){
        return $this->belongsTo('Image', 'img_id', 'id');
    }
    public function getAllAdvertising(){
        return self::with(['image'])
            ->select();
    }
}