<?php
/**
 * Created by PhpStorm.
 * User: 老王专用
 * Date: 2019/5/31
 * Time: 22:08
 */

namespace app\api\model;


class Enroll extends BaseModel
{
    protected $hidden = ['id','create_time','update_time'];
    public function getEnrollNumber(){
        $number = $this->find();
        return $number;
    }
}