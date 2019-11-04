<?php
/**
 * Created by PhpStorm.
 * User: 老王专用
 * Date: 2019/4/16
 * Time: 10:21
 */

namespace app\api\model_fo;


use app\exception\SignException;
use app\exception\SuccessMessage;
use think\Cache;
use think\Exception;

class Sign extends BaseModel
{
    protected $hidden = ['user_id','create_time','update_time'];
    public function getDateAttr($date){
        $date = date("Y-m-d",$date);
        return $date;
    }

    public function matters(){
        return $this->hasMany("Matters","sign_id","id");
    }
    public function user(){
        return $this->belongsTo("User","user_id","id");
    }
    public function getMattersBySignIdAndDate($date){
        $result = self::with(['matters'=>function($query){
            $query->with('img')->order('status');
        }])
            ->where("date",'=',$date)
            ->where('user_id','=',$this->user_id)
            ->find();
        if(!$result){
            $array['date'] = $date;
            $this->createSignDate($array);
            $result = self::with(['matters'=>function($query){
                $query->with('img')->order('status');
            }])
                ->where("date",'=',$date)
                ->where('user_id','=',$this->user_id)
                ->find();
        }
	if(Cache::has(config("setting.finish_flag").$this->user_id)){
            $result['flag'] = 1;
            Cache::rm(config("setting.finish_flag").$this->user_id);
        }else{
            $result['flag'] = 0;
        }  
        return $result;
    }
    public function getRanking($date){
        $result = self::with(['user'])
            ->where('date','=',$date)
	        ->where("study_time",">",0)
	        ->order('study_time', 'desc')
            ->limit(10)
            ->select();
        return $result;
    }
    public function getRankingByContinuity($date){
        $result = self::with(['user'])
            ->where('date','=',$date)
            ->where("study_time",">",0)
            ->order('study_time', 'desc')
            ->limit(10)
            ->select()
            ->toArray();
        foreach ($result as $value){
            $study_days[] = $value['user']['num'];
        }
        array_multisort($study_days,SORT_DESC,SORT_NUMERIC, $result);
        return $result;
    }
    public function createSignDate($array){
//        if(!$this->isEmptySignDate($array['date'])){
            $array['user_id'] = $this->user_id;
            $result = $this->save($array);
            if(!$result){
                throw new SignException([
                    'code' => 403,
                    'msg' => '新增日期信息异常',
                    'error_code' => '3002'
                ]);
//            }
            return $result;
        }
    }
    public function isEmptySignDate($date){
        $result = $this->where('date',"=",$date)->find();
        if(empty($result)){
            return false;
        }else{
            return true;
        }
    }
    public function setIncTodayStudyTime($duration){
        $date = strtotime(date('Y-m-d'));
        $result = self::where('date','=',$date)
	    ->where('user_id','=',$this->user_id)	
            ->setInc('study_time',$duration);
        if(!$result){
            throw new Exception("学习时间累加异常");
        }
        $sign = self::where('date','=',$date)
	->where('user_id','=',$this->user_id)
	->find();
        if($sign['plan_time']!=-1&&(int)$sign['study_time']>=(int)$sign['plan_time']){
            if($sign['sign_status'] != 1){
                self::where('date','=',$date)
		    ->where('user_id', '=', $this->user_id)
                    ->update([
                        'sign_status' => 1,
                    ]);
		        //缓存标记完成
                $this->setFinishCache();
                //累计打卡天数
                User::where('id','=',$this->user_id)
                    ->setInc('study_days',1);
                //连续打卡天数
                $this->ContinuousSign($date);
                return true;
            }
            return false;
        }
        return false;
    }
    public function getMonth($date){
	$today = strtotime(date('Y-m-d'));
        $this->ContinuousSign($today, false);
        $monthFirst = strtotime(date('Y-m-1',$date));
        $monthLast =  strtotime(date('Y-m-d',strtotime(date('Y-m',$date).'+1 month -1 day')));
        $result = $this->where('user_id', '=', $this->user_id)
            ->where('date', 'between', [$monthFirst,$monthLast])
            ->select();
        if(!$result){
            throw new SignException();
        }
        $user = User::get($this->user_id);
        $user['month'] = $result;
        return $user;
    }
    public function setPlanTime($array, $time){
        $array['user_id'] = $this->user_id;
        $model = self::where($array)->update([
            'plan_time' => $time,
        ]);
        if(!$model){
            if($model == 0){
                throw new SuccessMessage([
                    'msg' => '已更新成功，请勿重复操作'
                ]);
            }else{
                throw new SignException([
                    'msg' => '更新计划学习时间异常',
                    'errorCode' => 30003
                ]);
            }
        }
    }
    protected function ContinuousSign($date, $type=true){
        $sign = self::where("date","=",$date-3600*24)
            ->where('user_id', '=', $this->user_id)
            ->find();
        if($type){
            if(!$sign||$sign['sign_status'] != 1){
                $user = User::where('id','=',$this->user_id)
                    ->update([
                        'num' => 1,
                    ]);
            }else{
                User::where('id','=',$this->user_id)
                    ->setInc('num',1);
            }
        }else{
            if(!$sign||$sign['sign_status'] != 1){
                $today = self::where("date","=",$date)
                    ->where('user_id', '=', $this->user_id)
                    ->find();
                if($today['sign_status'] == 1){
                    User::where('id','=',$this->user_id)
                        ->update([
                            'num' => 1,
                        ]);
                }else{
                    User::where('id','=',$this->user_id)
                        ->update([
                            'num' => 0,
                        ]);
                }
            }
        }

    }
    protected function setFinishCache(){
        Cache::set(config("setting.finish_flag").$this->user_id,"finish");
    }
}
