<?php
/**
 * |-----------------------------------------------------------------------------------
 * @Copyright (c) 2014-2018, http://www.sizhijie.com. All Rights Reserved.
 * @Website: www.sizhijie.com
 * @Version: 思智捷管理系统 1.5.0
 * @Author : como 
 * 版权申明：szjshop网上管理系统不是一个自由软件，是思智捷科技官方推出的商业源码，严禁在未经许可的情况下
 * 拷贝、复制、传播、使用szjshop网店管理系统的任意代码，如有违反，请立即删除，否则您将面临承担相应
 * 法律责任的风险。如果需要取得官方授权，请联系官方http://www.sizhijie.com
 * |-----------------------------------------------------------------------------------
 */

return [
	'MYSQL'=>[
	    'host'                 => '127.0.0.1',
	    'port'                 => 3306,
	    'user'                 => 'xxx',
	    'password'             => 'xxx',
	    'database'             => 'xxx',
	    'prefix'			   => 'szj_',
	    'timeout'              => 30,
	    'charset'              => 'utf8',
	    'connect_timeout'      => '5',		//连接超时时间
	    'maxconn'			   => 50,		//最大链接数
	    'minconn'			   => 5,		//最小链接数	
	    'max_reconnect_times'  => 3, 		//断线重连时间

	]
];