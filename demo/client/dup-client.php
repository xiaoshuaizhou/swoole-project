<?php

    $client = new swoole_client(SWOOLE_SOCK_UDP);

    if (! $client->connect('127.0.0.1', 9502)){
        die('连接失败');
    }

    //接受客户端的消息
    fwrite(STDOUT, "请输入消息：");
    $msg = trim(fgets(STDIN));


    $client->send("{$msg}\n");

    //接受服务器消息
    echo $client->revc();

    $client->close();