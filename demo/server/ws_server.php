<?php

    //实例化一个sebsocket对象，传递host和端口；
    $server = new swoole_websocket_server("0.0.0.0", 9501);
    //设置参数
//    $server->set([]);
    $server->set([
        //配置默认静态文件的路径，与 enable_static_handler 配合使用。
        //设置document_root并设置enable_static_handler为true后，底层收到Http请求会先判断document_root路径下是否存在此文件，
        //如果存在会直接发送文件内容给客户端，不再触发onRequest回调。
        'document_root' => '/Applications/MAMp/htdocs/swoole-test/public', //默认静态文件存放的路径
        'enable_static_handler' => true,
    ]);
    //监听websocket连接打开事件
    $server->on('open', function (swoole_websocket_server $server, $request) {
        echo "服务器: 连接成功，客户端标识是 ： {$request->fd}\n";
    });
    // 监听message消息事件
    $server->on('message', function (swoole_websocket_server $server, $frame) {
        echo "消息来自： {$frame->fd} 号客户端 ，消息内容 : {$frame->data} , opcode : {$frame->opcode}, fin : {$frame->finish}\n";
        $server->push($frame->fd, "MonkeyKing!!!");
    });
    //关闭websocket连接
    $server->on('close', function ($ser, $fd) {
        echo "已关闭 {$fd} 号客户端 \n";
    });

    $server->start();