<?php
/**
 * Created by PhpStorm.
 * User: 老王专用
 * Date: 2019/4/20
 * Time: 9:41
 */

namespace app\api\controller\v2;

use app\api\model_fo\Sign as SignModel;

class Ranking
{
    public function getTodayRanking(){
        $date = strtotime(date("Y-m-d"));
        $result = (new SignModel())->getRanking($date);
        return json($result);
    }
    public function getTodayRankingByContinuity(){
        $date = strtotime(date("Y-m-d"));
        $result = (new SignModel())->getRankingByContinuity($date);
        return json($result);
    }
}