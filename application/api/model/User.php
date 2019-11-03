<?php
/**
 * Created by PhpStorm.
 * User: 老王专用
 * Date: 2019/4/15
 * Time: 17:17
 */

namespace app\api\model;



use app\api\service\TokenUser;
use think\Model;

class User extends Model
{
    protected $hidden = ["id","openid","create_time","update_time"];
    public function matter(){
        return $this->hasMany('Matters','user_id','id');
    }
    public function sign(){
        return $this->hasMany('Sign','user_id','id');
    }
    public function getByOpenID($openid){
        return $this->where('openid','=',$openid)
            ->find();
    }
    public function setMotto($motto){
        $user_id = TokenUser::getUidByTokenVar();
        self::where("id","=",$user_id)
            ->update([
                'motto' => $motto,
            ]);
        return $motto;
    }
    public function getDetailed($type){
        $user_id = TokenUser::getUidByTokenVar();
        $result = self::with(['sign','sign.matters'])
            ->where("id","=",$user_id)
            ->find();
        $study_time = 0;
        $matters_count = 0;
        $matters_finish = 0;
        if(strcmp($type,'week')==0){
            $date = strtotime('monday -7 day',time());
            $date = date("Y-m-d",$date);
            foreach ($result['sign'] as $item) {
                if (strcmp($date,$item['date'])>=0){
                    continue;
                }
                $study_time = $study_time+$item['study_time'];
                foreach ($item['matters'] as $matters){
                    if ($matters['finish'] == 1){
                        ++$matters_finish;
                    }
                    ++$matters_count;
                }
            }
        }else{
            $date = mktime(0,0,0,date('m'),1,date('Y'));
            $date = date("Y-m-d",$date);
            foreach ($result['sign'] as $item) {
                if (strcmp($date,$item['date'])>=0){
                    continue;
                }
                $study_time = $study_time+$item['study_time'];
                foreach ($item['matters'] as $matters){
                    if ($matters['finish'] == 1){
                        ++$matters_finish;
                    }
                    ++$matters_count;
                }
            }
        }
        unset($result['sign']);
        $result['study_time'] = $study_time;
        $result['matters_count'] = $matters_count;
        $result['matters_finish'] = $matters_finish;
        return $result;
    }
}
