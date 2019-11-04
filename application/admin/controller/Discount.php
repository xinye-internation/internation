<?php
/**
 * Created by PhpStorm.
 * User: 老王专用
 * Date: 2019/5/30
 * Time: 15:26
 */

namespace app\admin\controller;

use app\admin\model\Discount as DiscountModel;
use think\Controller;

class Discount extends BaseController
{
    public function index(){
        $model = new DiscountModel();
        $discounts = $model->select()
            ->toArray();
        return $this->fetch('',[
            'discounts' => $discounts,
        ]);
    }
    public function discount_add(){
        $model = new DiscountModel();
        if ($this->request->isPost()){
            //插入先不做限制
            $array = input("post.");
            $result = $model->insert($array);
            return $this->redirect(url('discount/index'));
        }
        return $this->fetch();
    }
    public function discount_edit($id){
        $model = new DiscountModel();
        if ($this->request->isPost()){
            //插入先不做限制
            $array = input("post.");
            $array['id'] = $id;
            $result = $model::update($array);
            return $this->redirect(url('discount/index'));
        }
        $discount = $model->where('id','=',$id)
            ->find()
            ->toArray();
        return $this->fetch('',[
            'discount' => $discount,
        ]);
    }
    public function discount_delete($id){
        $model = new DiscountModel();
        $result = $model->where('id','=',$id)
            ->delete();
        return $this->redirect(url('discount/index'));
    }
}