<?php
namespace app\index\controller;

use think\Controller;
use think\Session;
use xina\SaeTClientV2;
use xina\SaeTOAuthV2;

class Index extends Controller
{
    public function index()
    {
        $app_id = config("xina.WB_AKEY");
        $serct = config("xina.WB_SKEY");
        $callback_url = config("xina.WB_CALLBACK_URL");
        $o = new SaeTOAuthV2($app_id, $serct);
        $code_url = $o->getAuthorizeURL( $callback_url );
        var_dump($code_url);
        //TODO:显示登录页面
        return $this->fetch('',[
            'url' => $code_url,
        ]);
    }
    public function callback()
    {
        $app_id = config("xina.WB_AKEY");
        $serct = config("xina.WB_SKEY");
        $callback_url = config("xina.WB_CALLBACK_URL");
        $o = new SaeTOAuthV2($app_id, $serct);

        if (isset($_REQUEST['code'])) {
            $keys = array();
            $keys['code'] = $_REQUEST['code'];
            $keys['redirect_uri'] = $callback_url;
            $token = $o->getAccessToken('code', $keys);
        }

        if ($token) {
            session('token',$token);
            setcookie('weibojs_' . $o->client_id, http_build_query($token));
            return $this->fetch('',[
                'flag' => 1,
            ]);
        }else{
            return $this->fetch('',[
                'flag' => 0,
            ]);
        }
    }
    public function message(){
        $app_id = config("xina.WB_AKEY");
        $serct = config("xina.WB_SKEY");
        $token = Session::get('token');
        $c = new SaeTClientV2( $app_id , $serct , $token['access_token'] );
        $ms  = $c->home_timeline(); // done
        $uid_get = $c->get_uid();
        $uid = $uid_get['uid'];
        $user_message = $c->show_user_by_id( $uid);//根据ID获取用户等基本信息
        return json($user_message);
    }
}
