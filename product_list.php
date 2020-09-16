<?php
//echo 111;die;
    $page = $_POST['page']??1;
    $page_num = $_POST['page_num']??5;
    $limit = ($page - 1) * $page_num;

    $mysql = new Mysqli();
    $mysql->connect('127.0.0.1','root','','aliyun_1805');
    $mysql->query('set names utf8');
    $sql = 'select * from shop_goods_sku limit '.$limit.','.$page_num;
//echo $sql;
    $res = $mysql->query($sql)->fetch_all(MYSQLI_ASSOC);
    $info = [
        'status'=>200,
        'msg'=>'ok',
        'data'=>$res
    ];
    echo json_encode($info);