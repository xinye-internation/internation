<?php
/**
 * Created by PhpStorm.
 * User: 老王专用
 * Date: 2019/6/1
 * Time: 13:03
 */

namespace app\api\model;


use think\Model;

class Image extends Model
{
    protected $hidden = ['create_time','update_time'];
}