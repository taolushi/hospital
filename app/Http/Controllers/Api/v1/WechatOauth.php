<?php
/**
 * Created by PhpStorm.
 * User: zsjk
 * Date: 2018/7/5
 * Time: 16:37
 */
namespace App\Http\Controllers\Api\v1;
class WechatOauth  {
    public function getAccessTokenByCode() {
        $code = request()->get('code');
        $appid = config('app.wechat.appid');
        $secret = config('app.wechat.appSecret');
        $url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=".$appid."&secret=".$secret."&code=".$code."&grant_type=authorization_code";

    }
}