<?php
/**
 * Created by PhpStorm.
 * User: 老王专用
 * Date: 2019/5/30
 * Time: 14:19
 */

namespace app\admin\controller;

use app\admin\model\Advertising as AdvertisingModel;
use app\admin\model\Image;
use think\Controller;

class Advertising extends BaseController
{
    public function index(){
        $model = new AdvertisingModel();
        $ads = $model::with(['image'])
            ->select();
        return $this->fetch('',[
            'ads' => $ads,
        ]);
    }
    public function advertising_add()
    {
        if ($this->request->isPost()) {
            //图片上传业务代码
            $filedir = 'static/image/advertising/';
            $upload = new \app\admin\service\Image();
            $result = $upload->upload('photo', $filedir);
            if (!empty($result)) {
                $image = new Image();
                $image->save([
                    'img_url' => $result,
                ]);
                $img_id = $image->id;

                $model = new AdvertisingModel();
                $model->save([
                    'img_id' => $img_id,
                ]);
                return $this->redirect(url('advertising/index'));
            } else {
                return $this->error('上传错误');
            }
        }
        return $this->fetch();
    }
    public function advertising_delete($id){
        $model = new AdvertisingModel();
        $model->where('id', '=', $id)
            ->delete();
        return $this->redirect(url('advertising/index'));
    }
}