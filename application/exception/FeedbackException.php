<?php
/**
 * Created by PhpStorm.
 * User: 老王专用
 * Date: 2019/5/20
 * Time: 22:17
 */

namespace app\exception;


class FeedbackException extends BaseException
{
    public $code = "400";
    public $msg = "反馈留言";
    public $errorCode = "40001";
}