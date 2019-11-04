<?php
/**
 * Created by PhpStorm.
 * User: 老王专用
 * Date: 2019/5/28
 * Time: 22:14
 */

namespace app\admin\controller;


use app\admin\model\Admin;
use think\Cache;
use think\Controller;

class Index extends Controller
{
    public function login(){
        if ($this->request->isPost()){
            $array = input('post.');
            $admin = new Admin();
            $result = $admin->where('username','=',$array['username'])
                ->where('password','=',md5($array['password']))
                ->find();
            if ($result){
                $key = json_encode($result);
                Cache::set('key',$key,7200);
                return $this->redirect(url('admin/index'));
            }
        }
        return $this->fetch();
    }
}