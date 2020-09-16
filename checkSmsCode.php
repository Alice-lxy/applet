<?php
    $phone = $_POST['phone']?? "";
    $code = $_POST['code']?? "";
    $openid = $_POST['openid']?? "";
//    var_dump($_POST);die;

    $redis = new Redis();
    $redis->connect('127.0.0.1',6379);
    $redis_key = 'wxapplet_key'.$openid;
    $tel = $redis->hGet($redis_key,123);
    $vcode = $redis->hGet($redis_key,234);
//var_dump($tel);var_dump($vcode);die;
    if($phone!=$tel){
        $result = [
            'status'=>1,
            'mag'=>'phone fail',
            'data' => []
        ];
        echo json_encode($result);die;
    }elseif($code!=$vcode){
        $result = [
            'status'=>2,
            'mag'=>'code fail',
            'data' => []
        ];
        echo json_encode($result);die;
    }else{
        $mysql = new Mysqli();
        $mysql->connect('127.0.0.1','root','','demo');
        $time = time();
        $sql = 'insert into shop_code VALUES (NULL ,"'.$openid.'","'.$phone.'","'.$code.'",1,"'.$time.'","'.$time.'")';
        $sql_sql = 'insert into shop_bind VALUES (NULL ,NULL ,"'.$openid.'",2,1,"'.$time.'","'.$time.'")';
        $mysql->query($sql_sql);
        $res = $mysql->query($sql);
        if($res){
            $result = [
                'status'=>1000,
                'mag'=>'ok',
            ];
            echo json_encode($result);die;
        }

    }
