<?php
namespace App\Http\Controllers\Api\v1;

class WechatController {
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

=======
        $signature = request()->get('signature');
        $file = dirname(__FILE__).'/ttttt.txt';
//         echo file_put_contents($file,'3344455566646677777');
>>>>>>> 4ce6edd8a9ecf54f2c95be43c13cf00216e13db6
        $timestamp = request()->get('timestamp');
        $nonce = request()->get('nonce');
        $echostr = request()->get('echostr');
        $token = config('app.wechat.token');
        $tmpArr = [$nonce,$timestamp,$token];
        sort($tmpArr);
        $tmpstr = implode($tmpArr);
        $tmpstr = sha1($tmpstr);
        $file = dirname(__FILE__).'/ttttt.txt';
//         echo file_put_contents($file,$signature);
        $file = dirname(__FILE__).'/heihei.txt';
//         echo file_put_contents($file,$tmpstr);
        if ($signature == $tmpstr && $echostr) {

            echo $echostr;exit;

        }else {
            $postArr = file_get_contents('php://input');

            $postObj = simplexml_load_string( $postArr );
            $file = dirname(__FILE__).'/ttttt.txt';
//             echo file_put_contents($file,strtolower( $postObj->Event));
            if ($postObj) {
                if( strtolower( $postObj->MsgType) == 'event'){
                    if( strtolower($postObj->Event == 'subscribe') ){
                        //回复用户消息(纯文本格式)
                        $toUser   = $postObj->FromUserName;
                        $fromUser = $postObj->ToUserName;
                        $time     = time();
                        $msgType  =  'text';
                        $content  = '欢迎关注我们的微信公众账号'.$postObj->FromUserName.'-'.$postObj->ToUserName;
                        $template = "<xml>
    							<ToUserName><![CDATA[%s]]></ToUserName>
    							<FromUserName><![CDATA[%s]]></FromUserName>
    							<CreateTime>%s</CreateTime>
    							<MsgType><![CDATA[%s]]></MsgType>
    							<Content><![CDATA[%s]]></Content>
    							</xml>";
                        $info     = sprintf($template, $toUser, $fromUser, $time, $msgType, $content);
                        echo $info;
                        /*<xml>
                         <ToUserName><![CDATA[toUser]]></ToUserName>
                         <FromUserName><![CDATA[fromUser]]></FromUserName>
                         <CreateTime>12345678</CreateTime>
                         <MsgType><![CDATA[text]]></MsgType>
                         <Content><![CDATA[你好]]></Content>
                         </xml>*/
                
                
                    }else if(strtolower( $postObj->Event) == 'scan') {
                        $key = $postObj->EventKey;
                        $file = dirname(__FILE__).'/ttttt.txt';
                        echo file_put_contents($file,$key);
                    }
                }
            }
        }
//        print_r($signature);exit;
    }
    public function getQr() {
        $url = "https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token=%s";
        $params = [
            'action_name' => 'QR_SCENE',
            'action_info' => [
                'scene' => [
                    'scene_str' => 'doctor-30',
                    'scene_id' => 2,
                ]
            ]
        ];
        $access_token = $this->getAccess_token();
//         print_r($params);exit;
        $curl = sprintf($url,$access_token);
        $res = $this->curl_post($curl,json_encode($params),3000);
        var_dump($res);exit;
    }
    function curl_post($url, $params, $timeout){
        $ch = curl_init();//初始化
        curl_setopt($ch, CURLOPT_URL, $url);//抓取指定网页
        curl_setopt($ch, CURLOPT_HEADER, 0);//设置header
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//要求结果为字符串且输出到屏幕上
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
        curl_setopt($ch, CURLOPT_POST, 1);//post提交方式
        curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
        $data = curl_exec($ch);//运行curl
        curl_close($ch);
        return ($data);
    }
    public function curl_get_https($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.11 (KHTML, like Gecko) Chrome/23.0.1271.1 Safari/537.11');
        $res = curl_exec($ch);
        $rescode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        return $res;
    }
    public function getAccess_token() {
        $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=%s&secret=%s";
        $curl = sprintf($url,config('app.wechat.appid'),config('app.wechat.appSecret'));
        $res = $this->curl_get_https($curl);
        $res = json_decode($res);
//         print_r($res);exit;
        return $res->access_token;
//         print_r($curl);exit;
    }
    
    
    

}
