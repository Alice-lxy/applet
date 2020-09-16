<?php
    $phone = $_POST['phone']?? "";
    $openid = $_POST['openid']?? "";
//    echo $openid;
    if(!$phone){
        $result = [
            'status'=>1,
            'mag'=>'phone not found',
            'data' => []
        ];
        echo json_encode($result);die;
    }else{
        //发送短信
        $rand = rand(1000,9999);
        code($phone,$rand);

        $redis_key = 'wxapplet_key'.$openid;
        $redis = new Redis();
        $redis->connect('127.0.0.1',6379);
        $redis->hSet($redis_key,123,$phone);
        $redis->hSet($redis_key,234,$rand);

        $result = [
            'status'=>1000,
            'mag'=>'ok',
            'code' => $rand
        ];
        echo json_encode($result);die;
    }
    function code($phone,$rand){
        date_default_timezone_set('GMT');
        #手机号码
        $phone = $phone;
        #短信签名名称
        $signName = 'layui后台布局';
        #AccessKeyID
        $appid =  'LTAIct2W1muDE6qb';
        #AccessKeySecret
        $secret = 'BY7Epn2iWqgyAKDOWdlh6h1gr7cCXK';
        #模板code
        $tplid = 'SMS_151770141';
        $tplParam = json_encode(['code' => $rand]);//随机验证码
        $params = [
            'AccessKeyId' => $appid,
            'Timestamp'   => date('Y-m-d H:i:s'),
            'SignatureMethod'=>'HMAC-SHA1',
            'SignatureVersion'=> '1.0',
            'SignatureNonce'  => uniqid(),//随机码
            //'Signature' => ''
            'Format'      => 'JSON',
            //业务参数
            'Action'       => 'SendSms',
            'Version'     => '2017-05-25',
            'RegionId'    => 'cn-hangzhou',
            'PhoneNumbers' => $phone,//接收号码
            'SignName'      => $signName,//签名
            'TemplateCode'  => $tplid,//模板id
            'TemplateParam' => $tplParam,

        ];
        //排序
        ksort($params);
        //http_build_query($params)
        $str = '';
        foreach($params as $k => $v){
            $str .= urlencode($k) . '=' . urlencode($v) . '&';
        }
        $str = substr($str,0,-1);
        $str = str_replace(['+','*','%7E'],['%20','%2A','~'],$str );
        $new_str = 'GET&' . urlencode('/') . '&' . urlencode($str);
        $sign = base64_encode(hash_hmac('sha1', $new_str, $secret . '&',true));
        $sign = urlencode($sign);
        $url = 'http://dysmsapi.aliyuncs.com/?Signature=' . $sign . '&'.  $str;
        file_get_contents($url);
    }