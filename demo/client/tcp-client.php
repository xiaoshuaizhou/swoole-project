<?php

    //连接 swoole tcp 服务
    $client = new swoole_client(SWOOLE_SOCK_TCP);
    //连接失败，返回错误信息
    if (!$client->connect('127.0.0.1', 9501))
    {
        exit("connect failed. Error: {$client->errCode}\n");
    }

    // php cli 模式
    //用户输入消息
    fwrite(STDOUT, "请输入消息：" . "\n");
    //获取消息
    $msg = trim(fgets(STDIN));
    //发送消息到 tcp 服务端
    $client->send("{$msg} \n");
    //接受服务器的消息
    $result =  $client->recv();
    //输出消息
    echo $result;

    //关闭连接
    $client->close();

