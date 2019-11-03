<?php
/**
 * Created by PhpStorm.
 * User: 老王专用
 * Date: 2019/5/20
 * Time: 22:15
 */

namespace app\api\model;

use think\Exception;

class Feedback extends BaseModel
{
    public function saveFeedback($array){
        $array['user_id'] = $this->user_id;
        $result = self::save($array);
        if (!$result){
            throw new Exception('留言反馈异常');
        }
    }
}