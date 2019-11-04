<?php
/**
 * Created by PhpStorm.
 * User: 老王专用
 * Date: 2019/6/1
 * Time: 11:59
 */

namespace app\api\validate;


class EnrollCheck extends BaseValidate
{
    protected $rule = [
        'truename' => 'require|chs',
        'number' => 'require',
        'address' => 'chsDash',
        'driver_id' => 'isMustInteger',
        'discount_id' => 'isMustInteger',
    ];
    protected $msg = [

    ];
}