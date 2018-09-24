<?php


    //创建Server对象，监听 127.0.0.1:9501端口
    $serv = new swoole_server("127.0.0.1", 9501);

    /**
     * 连接参数设置
     */
    $serv->set([
    //    'reactor_num' => 2, //reactor thread num
        'worker_num' => 4,    //worker 进程数
    //        'backlog' => 128,   //listen backlog
        'max_request' => 50, // 每个worker 处理的请求数量
    //        'dispatch_mode' => 1,
    ]);

    /**
     * 监听连接进入事件
     * @param $serv server 服务
     * @param $fd int 自增 客户端连接服务端的唯一标识
     * @param $reactor_id 线程ID
     */
    $serv->on('connect', function ($serv, $fd, $reactor_id) {
        echo "Client: {$reactor_id} -- {$fd} - Connect.\n";
    });


    /**
     * 监听数据接收事件
     */
    $serv->on('receive', function ($serv, $fd, $reactor_id, $data) {
        $serv->send($fd, "Server: " . $reactor_id . '--' . $fd . "data --->" . $data);
    });

    //监听连接关闭事件
    $serv->on('close', function ($serv, $fd) {
        echo "Client: Close.\n";
    });

    //启动服务器
    $serv->start();