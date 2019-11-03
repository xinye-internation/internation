<?php
/**
 * Created by PhpStorm.
 * User: 老王专用
 * Date: 2019/5/20
 * Time: 22:22
 */

namespace app\api\controller\v1;

use app\api\validate\Feedback as FeedValidate;
use app\api\model\Feedback as FeedbackModel;
use app\exception\SuccessMessage;

class Feedback
{
    public function setFeedback(){
        $validate = new FeedValidate();
        $validate->goCheck();
        $array = $validate->getDateByRule(input('post.'));
        $model = new FeedbackModel();
        $model->saveFeedback($array);
        throw new SuccessMessage();
    }
}