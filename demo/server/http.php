<?php
    /*
     * HttpServer
     */

    $http_server = new swoole_http_server('0.0.0.0', 8811);

    $http_server->set([
        //配置默认静态文件的路径，与 enable_static_handler 配合使用。
        //设置document_root并设置enable_static_handler为true后，底层收到Http请求会先判断document_root路径下是否存在此文件，
        //如果存在会直接发送文件内容给客户端，不再触发onRequest回调。
        'document_root' => '/Applications/MAMp/htdocs/swoole-test/public', //默认静态文件存放的路径
        'enable_static_handler' => true,
    ]);

    $http_server->on('request', function ($req, $resp) {
        //http 的响应信息；
        $resp->cookie('monkeyUser', 'monkeyUser');
        //end 方法只能传递字符串，end是浏览器输出
        $resp->end("<h1>" . json_encode($req->get) . "</h1>");
    });

    $http_server->start();