<?php
/**
 * Created by PhpStorm.
 * User: yf
 * Date: 2019-01-01
 * Time: 20:06
 */

return [
    'SERVER_NAME' => "szjkj",
    'MAIN_SERVER' => [
        'LISTEN_ADDRESS' => '0.0.0.0',
        'PORT' => 9501,
        'SERVER_TYPE' => EASYSWOOLE_WEB_SERVER, //可选为 EASYSWOOLE_SERVER  EASYSWOOLE_WEB_SERVER EASYSWOOLE_WEB_SOCKET_SERVER,EASYSWOOLE_REDIS_SERVER
        'SOCK_TYPE' => SWOOLE_TCP,
        'RUN_MODEL' => SWOOLE_PROCESS,
        'SETTING' => [
            'worker_num' => 4,
            'task_worker_num' => 4,
            'reload_async' => true,
            'task_enable_coroutine' => true,
            'max_wait_time'=>3,
            'package_max_length'=> 2 * 1024 * 1024,                         //文上传大小限制
            //'enable_static_handler' => true,
            //'document_root' => './public/',                    // v4.4.0以下版本, 此处必须为绝对路径
        ],
    ],
    'TEMP_DIR' => EASYSWOOLE_ROOT.'/runtime/temp',
    'LOG_DIR' => EASYSWOOLE_ROOT.'/runtime/log'
];
