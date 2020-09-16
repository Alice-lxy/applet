<?php
    $openid = $_POST['openid']??"";
    $type = $_POST['type']??"";
    if(empty($openid)){
        $result = [
            'status'=>1,
            'msg'=>'openid not found',
            'data'=>[]
        ];
        echo json_encode($result);exit;
    }
    $mysql = new Mysqli('127.0.0.1','root','','demo');
    $sql = 'select * from shop_bind where unique_id = "'.$openid.'" and type = "'.$type.'"';
    $res = $mysql->query($sql);
    $arr = $res->fetch_assoc();
    if(!$arr){
        $result = [
            'status'=>2,
            'msg'=>'this data not found',
            'data'=>[]
        ];
        echo json_encode($result);exit;
    }else{
        $result = [
            'status'=>1000,
            'msg'=>'ok',
            'data'=>$arr
        ];
       echo json_encode($result);
    }
