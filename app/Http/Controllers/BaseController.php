<?php
/**
 * Created by PhpStorm.
 * User: apple
 * Date: 2018/7/4
 * Time: 23:22
 */
namespace App\Http\Controllers;
use Illuminate\Routing\Controller;
class BaseController extends Controller {
    public function __construct() {
        $user_info = session('user_info');
        $openid = session('openid');
        if (empty($user_info) && empty($openid)) {
            $appid = config('app.wechat.appid');
            $redirect_url = '';
            $redirect_url = urlencode($redirect_url);
            $scope = 'snsapi_base';
            $state = 1;
            $url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=".$appid."&redirect_uri=".$redirect_url."&response_type=code&scope=".$scope."&state=".$state."#wechat_redirect";
            header('Location: '.$url, true, 301);

        }
    }
}