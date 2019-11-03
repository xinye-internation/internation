<?php
/**
 * Created by PhpStorm.
 * User: 老王专用
 * Date: 2019/5/20
 * Time: 22:18
 */

namespace app\api\validate;


class Feedback extends BaseValidate
{
    protected $rule = [
        'category' => "require",
        'content' => 'require',
    ];
    protected $message = [

    ];
}