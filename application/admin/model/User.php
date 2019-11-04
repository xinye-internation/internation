<?php
/**
 * Created by PhpStorm.
 * User: 老王专用
 * Date: 2019/6/1
 * Time: 10:58
 */

namespace app\admin\model;


use think\Model;

class User extends Model
{
    public function driver(){
        return $this->belongsTo('Driver', 'driver_id','id');
    }
    public function discount(){
        return $this->belongsTo('Discount', 'discount_id','id');
    }
    public function getAllEnroll($name=""){
        if (empty($name)){
            $user = self::with(['driver','discount'])
                ->where('enroll', '=', 1)
                ->paginate(10,false, [
                    'type'=>'BootstrapDetailed'
                ]);
            return $user;
        }else{
            $user = self::with(['driver','discount'])
                ->where('enroll', '=', 1)
                ->where('truename','=',$name)
                ->paginate(10,false, [
                    'type'=>'BootstrapDetailed'
                ]);
            return $user;
        }

    }
}