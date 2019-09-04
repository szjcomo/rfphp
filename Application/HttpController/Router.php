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

namespace App\HttpController;
use szjcomo\szjcore\Routers as AppRouter;
/**
 * 继承自核心路由功能
 */
Class Router extends AppRouter{

	/**
	 * [_registerRouter description]
	 * @Author    como
	 * @DateTime  2019-08-12
	 * @copyright 思智捷管理系统
	 * @version   [1.5.0]
	 * @return    [type]     [description]
	 */
	Protected static function _registerRouter($route){
		/**
		 * 默认首页路由  注意 从实战测试中验证 只针对ip直接访问端口有效 
		 * 绑定域名后无效
		 */
		$route->addRoute('GET','/','/Index/postindex');
	}

}