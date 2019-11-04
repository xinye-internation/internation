<?php
/**
 * Created by PhpStorm.
 * User: 老王专用
 * Date: 2019/5/31
 * Time: 19:02
 */

namespace app\admin\service;


class Image
{
    public function upload($parm, $filedir){
        if(!$_FILES[$parm]['tmp_name'])
        {
            $this->error("图片添加失败!");
        }

        $type = $_FILES[$parm]['type'];
        if($type == 'image/jpeg'){
            $emp = '.jpg';
        }elseif($type == 'image/png'){
            $emp = '.png';
        }elseif($type == 'image/gif'){
            $emp = '.png';
        }else{
            $emp = '.jpg';
        }

        $tmp= getimagesize($_FILES[$parm]['tmp_name']);
        if(empty($tmp['mime'])){
            $this->error("图片格式不正确！！！");
        }
        $filename = rand(1000,9999).time().$emp;
        if(move_uploaded_file($_FILES[$parm]['tmp_name'],$filedir.$filename)){
            return $filedir.$filename;
        }else{
            return '';
        }
    }
}