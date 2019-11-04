<?php
/**
 * Created by PhpStorm.
 * User: 老王专用
 * Date: 2019/5/31
 * Time: 22:04
 */

namespace app\api\controller\v1;

use app\api\model\Discount;
use app\api\model\User as UserModel;
use app\api\model\Advertising;
use app\api\model\Driver;
use app\api\model\Enroll;
use app\api\validate\EnrollCheck;
use app\exception\SuccessMessage;


class Index
{
    public function index(){
        $advertising = new Advertising();
        $images = $advertising->getAllAdvertising();

        $enroll = new Enroll();
        $number = $enroll->getEnrollNumber();

        //驾校价格应该替换成套餐价格
        $driver = new Driver();
        $drivers = $driver->getDriverList();
        $array = [];
        $array['images'] = $images;
        $array['number'] = $number['number'];
        $array['drivers'] = $drivers;
        return json($array);
    }
    public function sign_up(){
        $user = new UserModel();
//        if($user->getUserEnrollStatus() == 1){
//            $array = [];
//            $array['flag'] = 0;
//            return json($array);
//        }
        $validate = new EnrollCheck();
        $validate->goCheck();
        $array = $validate->getDateByRule(input('post.'));
        $set = '415813765@qq.com';
        $title = $array['truename'].'的报名信息';
        $message =
            "<h3>名字：".$array['truename']."</h3>
             <h3>联系方式：<a>".$array['number']."</a></h3>
             <h3>地址：".$array['address']."</h3>
        ";
        $name = $array['truename'];
        \Mail::Qmail($set ,$name ,$title ,$message);
        $result = $user->updateUserInformation($array);
        return new SuccessMessage();
    }
    public function driver($driver_id){
        //驾校价格应该替换成套餐价格
        $driver = new Driver();
        $result = $driver->getDriverInformation($driver_id);
        return json($result);
    }
    public function discount(){
        $discount = new Discount();
        $result = $discount->order('recommend','desc')
            ->select();
        return json($result);
    }
}