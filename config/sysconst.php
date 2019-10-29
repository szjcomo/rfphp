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
	//http控制器对象池最大数量
	'HTTP_CONTROLLER_POOL_MAX_NUM'	=>600,
	// 默认全局过滤方法 用逗号分隔多个
	'default_filter'				=>'htmlspecialchars',
	// 是否开启IP次数限制访问
	'iplimit_open'					=>true,
	// 每个IP每秒限制最大访问次数
	'iplimit_secode'				=>100,
	// 是否开启可以跨域请求
	'cross_domain'					=>false,
	// 是否开启内置缓存
	'fast_cache_open' 				=>true,
	// 内置缓存配置项
	'fast_cache_config' 			=>[
		// 设置内置缓存目录
		'write_path' 				=>EASYSWOOLE_ROOT.'/runtime/cache/',
		// 数据写入频率 默认每间隔5秒检查写入一次 
		'write_time_rate'			=>5
	],
	// 是否开启服务热重载
	'hot_reload_start'				=>true,
	// 热重载配置项
	'hot_reload_config'				=>[
		//是否禁用inotity扩展 （如果没有安扩展 建议为true  如果安装了扩展 建议为false）
		'disableInotify'=>true,
		//需要监控的目录
		'monitorDir'=>EASYSWOOLE_ROOT . '/Application',
		//需要监控的后缀
		'monitorExt'=>['php']
	]
];