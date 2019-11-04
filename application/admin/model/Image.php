<?php
/**
 * Created by PhpStorm.
 * User: 老王专用
 * Date: 2019/5/30
 * Time: 21:12
 */

namespace app\admin\model;


use think\Model;

class Image extends Model
{
    protected function urlPrefix($value,$date){
        $url = $value;
        if($date['from'] == 0){
            $url = config('setting.url_prefix').$value;
        }
        return $url;
    }
    public function getImgUrlAttr($value,$date){
        return $this->urlPrefix($value,$date);
    }
}