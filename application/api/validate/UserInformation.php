<?php
/**
 * Created by PhpStorm.
 * User: 老王专用
 * Date: 2019/5/21
 * Time: 11:14
 */

namespace app\api\validate;


class UserInformation extends BaseValidate
{
    protected $rule = [
        'type' => 'checkInformation'
    ];
    protected $msg = [
        'type' => '获取详细只能按\'month\'和\'week\'分类'
    ];
}