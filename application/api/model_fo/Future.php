<?php
/**
 * Created by PhpStorm.
 * User: 老王专用
 * Date: 2019/4/16
 * Time: 19:47
 */

namespace app\api\model_fo;


use app\api\service\Token;
use app\exception\BaseException;
use app\exception\FutureException;
use traits\model\SoftDelete;

class Future extends BaseModel
{
    use SoftDelete;
    protected $hidden = ['create_time','update_time','delete_time','user_id'];

    public function getFutureDateAttr($date){
        $date = date("Y-m-d",$date);
        return $date;
    }
    public function updateFuture($array){
        $this->userConsistency($array['id']);
        $array['future_date'] = strtotime($array['future_date']);
        $model = self::update($array);
        if(!$model){
            throw new BaseException([
                'msg' => '用户不一致，不允许此操作',
                'code' => 403,
                'error_code' => 1004
            ]);
        }
    }
    public function destroyFuture($id){
        $this->userConsistency($id);
        $model = self::destroy($id);
        if(!$model){
            throw new FutureException([
                'code' => 403,
                'msg' => '未来计划删除异常',
                'errorCode' => 4004
            ]);
        }
    }
    protected function userConsistency($id){
        $model = self::get($id);
        if(!$model){
            throw new FutureException([
                'msg' => '计划已被删除，请勿重复操作',
                'code' => 403,
                'errorCode' => 4005
            ]);
        }
        if($model->user_id != $this->user_id){
            throw new BaseException([
                'msg' => '用户不一致，不允许此操作',
                'code' => 403,
                'errorCode' => 1004
            ]);
        }
    }
}