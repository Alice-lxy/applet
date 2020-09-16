<?php
    $code = $_POST['code']??"";

    if(empty($code)){
        $result = [
            'status'=>1,
            'msg'=>'code not found',
            'data'=>[]
        ];
        echo json_encode($result);exit;
    }
    $app_id = 'wx6b732f8395d1b29e';
    $app_secret = 'f750fc6df3c5e852774ecee1866c2a34';
    $url = 'https://api.weixin.qq.com/sns/jscode2session?appid='.$app_id.'&secret='.$app_secret.'&js_code='.$code.'&grant_type=authorization_code';
    $data = file_get_contents($url);
    echo $data;
