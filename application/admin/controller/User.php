<?php
/**
 * Created by PhpStorm.
 * User: 老王专用
 * Date: 2019/5/28
 * Time: 22:36
 */

namespace app\admin\controller;

use app\admin\model\Practice as PracticeModel;
use app\admin\model\Contract;
use app\admin\model\User as UserModel;
use think\Controller;

class User extends BaseController
{
    public function index(){
        $model = new UserModel();
        if ($this->request->isPost()){
            $name = input('post.');
            $users = $model->getAllEnroll($name['truename']);
            return $this->fetch('',[
                'users' => $users,
            ]);
        }
//        for ($i=0; $i<50; $i++){
//            $array = [];
//            $array['openid'] = 'sa1cds5d5sax4s1a56xsa16';
//            $array['truename'] = 'user'.$i;
//            $array['number'] = '12345678901';
//            $array['address'] = 'user'.$i;
//            $array['driver_id'] = 8;
//            $array['discount_id'] = 3;
//            $model->insert($array);
//        }
        $users = $model->getAllEnroll();
        return $this->fetch('',[
            'users' => $users,
        ]);
    }
    public function user_edit($id){
        $model = new UserModel();
        if ($this->request->isPost()){
            //插入先不做限制
            $array = input("post.");
            $array['id'] = $id;
            $result = $model::update($array);
            return $this->redirect(url('user/index'));
        }
        $user = $model->where('id','=',$id)
            ->find()
            ->toArray();
        $drivers = \app\admin\model\Driver::all();
        $discounts = \app\admin\model\Discount::all();
        return $this->fetch('',[
            'user' => $user,
            'drivers' => $drivers,
                'discounts' => $discounts
        ]);
    }
    public function reserve(){
        $model = new PracticeModel();
        if ($this->request->isPost()) {
            $array = input('post.');
            if(!empty($array['date'])){
                $date = strtotime($array['date']);
                $reserves = $model->with(['user','user.driver'])
                    ->where('date','=',$date)
                    ->select();
                return $this->fetch('', [
                    'reserves' => $reserves,
                ]);
            }
        }
        $reserves = $model->with(['user','user.driver'])
            ->select()
            ->toArray();
        return $this->fetch('', [
            'reserves' => $reserves,
        ]);
    }
    public function reserve_edit($id){
        $model = new PracticeModel();
        if ($this->request->isPost()){
            //插入先不做限制
            $array = input("post.");
            $array['id'] = $id;
            $array['date'] = strtotime($array['date']);
            $result = $model::update($array);
            return $this->redirect(url('user/reserve'));
        }
        $reserve = $model->where('id','=',$id)
            ->find()
            ->toArray();
        return $this->fetch('',[
            'reserve' => $reserve,
        ]);
    }
    public function contract($id){
        $model = new Contract();
        $contract = $model->where('user_id', '=', $id)
            ->find();
        return $this->fetch('',[
            'id' => $id,
            'contract' => $contract
        ]);
    }
}