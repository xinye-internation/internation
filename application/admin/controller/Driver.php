<?php
/**
 * Created by PhpStorm.
 * User: 老王专用
 * Date: 2019/5/30
 * Time: 14:20
 */

namespace app\admin\controller;

use app\admin\model\Coach;
use app\admin\model\Driver as DriverModel;
use app\admin\model\DriverImage;
use app\admin\model\Image;
use think\Controller;

class Driver extends BaseController
{
    public function index(){
        $model = new DriverModel();
        $drivers = $model::all();
        return $this->fetch('',['drivers' => $drivers]);
    }
    public function driver_add(){
        $model = new DriverModel();
        if ($this->request->isPost()){
            //插入先不做限制
            $array = input("post.");
            $result = $model->insert($array);
            return $this->redirect(url('driver/index'));
        }
        return $this->fetch();
    }
    public function driver_edit($id){
        $model = new DriverModel();
        if ($this->request->isPost()){
            //插入先不做限制
            $array = input("post.");
            $array['id'] = $id;
            $result = $model::update($array);
            return $this->redirect(url('driver/index'));
        }
        $driver = $model->find($id);
        return $this->fetch('',[
            'driver' => $driver,
        ]);
    }
    public function driver_delete($id){
        $model = new DriverModel();
        $coach_model = new Coach();
        $driver_image = new DriverImage();
        $driver = $model->where('id', '=', $id)->delete();
        $coach = $coach_model->where('driver_id', '=', $id)->delete();
        $photo = $driver_image->where('driver_id', '=', $id)->delete();
        return $this->redirect(url('driver/index'));
    }



    public function coach($id){
        $model = new Coach();
        $coachs = $model->where('driver_id','=',$id)
            ->select();
        return $this->fetch('', [
            'id' => $id,
            'coachs' => $coachs,
        ]);
    }
    public function coach_add($id){
        $model = new Coach();
        if ($this->request->isPost()){
            //插入先不做限制
            $array = input("post.");
            $result = $model->insert($array);
            return $this->redirect(url('driver/coach',['id'=>$array['driver_id']]));
        }
        return $this->fetch('', ['id' => $id]);
    }
    public function coach_edit($id){
        $model = new Coach();
        if ($this->request->isPost()){
            //插入先不做限制
            $array = input("post.");
            $array['id'] = $id;
            $result = $model::update($array);
            return $this->redirect(url('driver/coach',['id'=>$array['driver_id']]));
        }
        $coach = $model
            ->find($id);
        return $this->fetch('', [
            'id' => $id,
            'coach' => $coach
        ]);
    }
    public function coach_delete($id,$driver_id){
        $model = new Coach();
        $coach = $model->where('id', '=', $id)
            ->delete();
        return $this->redirect(url('driver/coach',['id'=>$driver_id]));
    }


    public function photo($id){
        $model = new DriverModel();
        $all = $model->getDriverPhotos($id);
        return $this->fetch('', [
            'id' => $id,
            'photos' => $all['image'],
        ]);
    }
    public function photo_add($id){
        if ($this->request->isPost()){
            //图片上传业务代码
            $filedir = 'static/image/driver/';
            $upload = new \app\admin\service\Image();
            $result = $upload->upload('photo', $filedir);
            if (!empty($result)){
                $image = new Image();
                $image->save([
                    'img_url' => $result,
                ]);
                $img_id = $image->id;

                $driver_image = new DriverImage();
                $driver_image->save([
                    'driver_id' => $id,
                    'img_id' => $img_id
                ]);
                return $this->redirect('driver/photo',['id' => $id]);
            }else{
                return $this->error('上传错误');
            }


        }
        return $this->fetch('', ['id' => $id]);
    }
}