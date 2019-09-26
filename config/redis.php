<?php
/**
 * |-----------------------------------------------------------------------------------
 * @Copyright (c) 2014-2018, http://www.sizhijie.com. All Rights Reserved.
 * @Website: www.sizhijie.com
 * @Version: 思智捷信息科技有限公司
 * @Author : szjcomo 
 * |-----------------------------------------------------------------------------------
 */
return [
	//是否注册redis服务 如果需要使redis 请先安装phpredis扩展
	'is_redis_register'				=> false,
	//redis配置项
	'REDIS'=>[
		[
			'host'          		=> '127.0.0.1',
			'port'          		=> '6379',
			'auth'          		=> 'szjcomo',
			'db'            		=> 0,//选择数据库,默认为0
			'intervalCheckTime'    	=> 30 * 1000,//定时验证对象是否可用以及保持最小连接的间隔时间
			'maxIdleTime'          	=> 15,//最大存活时间,超出则会每$intervalCheckTime/1000秒被释放
			'maxObjectNum'         	=> 20,//最大创建数量
			'minObjectNum'         	=> 5,//最小创建数量 最小创建数量不能大于等于最大创建
		]
	]
];
