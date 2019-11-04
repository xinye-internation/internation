<?php
/**
 * Created by PhpStorm.
 * User: 老王专用
 * Date: 2019/6/1
 * Time: 12:22
 */

namespace app\api\model;



class User extends BaseModel
{
    public function updateUserInformation($array){
        $array['id'] = $this->user_id;
        $array['enroll'] = 1;
        return self::update($array);
    }
    public function getUserEnrollStatus(){
        $user = $this->where('id', '=', $this->user_id)
            ->find()
            ->toArray();
        return $user['enroll'];
    }
}