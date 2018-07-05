<?php
namespace App\Http\Controllers\Api\v1;
use App\Http\Controllers\BaseController;

class WechatController extends BaseController {
    /**
     * @author taolushi
     * 微信公共号接入验证
     */
    public function index() {
//        echo 'signature55555';
        $tmp = fopen('./heihei.txt','w+');

        $signature = request()->get('signature');
        print_r(fwrite($tmp,$signature));
        file_put_contents('');

        $timestamp = request()->get('timestamp');
        $nonce = request()->get('nonce');
        $echostr = request()->get('echostr');
        $token = config('app.wechat.token');
        $tmpArr = [$nonce,$timestamp,$token];
        sort($tmpArr);
        $tmpstr = implode($tmpArr);
        $tmpstr = sha1($tmpstr);
        if ($signature == $tmpstr && $echostr) {
            echo $echostr;exit;

        }
//        print_r($signature);exit;
    }

}