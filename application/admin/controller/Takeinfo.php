<?php
/**
 * Created by PhpStorm.
 * User: 老王专用
 * Date: 2019/5/25
 * Time: 12:22
 */

namespace app\admin\controller;


use app\admin\model\Tiku;
use think\response\Json;


class Takeinfo extends Tiku
{
    public function index(){
//        require '../extend/Faker-master/src/autoload.php';
////        $faker = Faker\Factory::create('zh_CN');  //选择中文
//////var_dump($faker);
////
//////简单使用，可用循环输出多个。
////        echo $faker->name(),'<br>';           //陶洋
////        echo $faker->address(),'<br>';        //成都沈河区
////        echo $faker->email(),'<br>';          //voluptate60@sina.com
////        echo $faker->password(),'<br>';          //CYgaNBpR>.
////        echo $faker->userName,'<br>';          //CYgaNBpR>.
////
////        echo '<hr>';






//        header("Content-type: application/json; charset=utf-8");
//        $params = array(
//            'type' => 'c1',
//            'subject' => '4',
//            'pagesize' => '100',
//            'pagenum' => '12',
//            'sort' => 'normal',
//            'appkey' => '43db3c8bf24828870bd1e0ba220f242d'
//        );
//        $url = 'https://way.jd.com/jisuapi/driverexamQuery1';
//        $result = wx_http_request($url, $params );
//        $array = json_decode($result, true);
//        $return = $array['result']['result']['list'];
//        $model = new Tiku();
//        $result = $model->where('subject', '=', 1)
//            ->where('pic', 'neq', '')
//            ->select()
//            ->count();
//        var_dump($result);
//        foreach ($result as $value){
//            getImage($value['pic'],'./upload');
//        }

//        foreach ($return as $value){
//            if(empty($value['option1'])){
//                $value['topic_types'] = '选择题';
//            }else{
//                $value['topic_types'] = '多选题';
//            }
//            $value['type'] = 'c1';
//            $value['subject'] = 4;
//            var_dump($value);
//            var_dump($model->insert($value));
//        }
    }
}