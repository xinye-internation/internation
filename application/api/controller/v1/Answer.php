<?php
/**
 * Created by PhpStorm.
 * User: 老王专用
 * Date: 2019/6/2
 * Time: 12:04
 */

namespace app\api\controller\v1;


use app\api\model\Tiku;

class Answer
{
    public function getTiKuCount($type=1){
        $tiku = new Tiku();
        $count = $tiku->where('subject','=',$type)
            ->count();
        return json($count);
    }
}