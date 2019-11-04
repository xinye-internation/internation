<?php
/**
 * Created by PhpStorm.
 * User: 老王专用
 * Date: 2019/6/2
 * Time: 13:43
 */

namespace app\admin\controller;

use app\admin\model\Admin as AdminModel;

class Admin extends BaseController
{
    public function index(){
        $model = new AdminModel();
        $admins = $model->select();
        return $this->fetch('',[
            'admins' => $admins,
        ]);
    }
    public function admin_add(){
        $model = new AdminModel();
        if ($this->request->isPost()){
            //插入先不做限制
            $array = input("post.");
            $result = $model->save($array);
            return $this->redirect(url('admin/index'));
        }
        return $this->fetch();
    }
    public function admin_edit($id){
        $model = new AdminModel();
        if ($this->request->isPost()){
            //插入先不做限制
            $array = input("post.");
            $array['id'] = $id;
            $array['password'] = md5($array['password']);
            $result = $model::update($array);
            return $this->redirect(url('admin/index'));
        }
        $admin = $model->where('id','=',$id)
            ->find()
            ->toArray();
        return $this->fetch('',[
            'admin' => $admin,
        ]);
    }
    public function admin_delete($id){
        $model = new AdminModel();
        $admin = $model->where('id','=',$id)
            ->delete();
        return $this->redirect(url('admin/index'));
    }
}