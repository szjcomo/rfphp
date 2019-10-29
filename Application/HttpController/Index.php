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

use szjcomo\szjcore\Mysql;
use szjcomo\szjcore\Cache;
use App\controller\Base;

/**
 * 自定义控制器
 */
class Index extends Base 
{
	/**
	 * [index 首页访问]
	 * @Author    como
	 * @DateTime  2019-08-09
	 * @copyright 思智捷管理系统
	 * @version   [1.5.0]
	 * @return    [type]     [description]
	 */
	public function index()
	{
		//return $this->context->redirect('/Index/postindex');
		$ip = $this->context->getip();
		$this->view->assign(['uname'=>'河源思智捷信息科技有限公司','ip'=>$ip.'123456']);
		$this->fetch('home/Index_index');
	}
	/**
	 * [adddata description]
	 * @Author    como
	 * @DateTime  2019-08-14
	 * @copyright 思智捷管理系统
	 * @version   [1.5.0]
	 * @return    [type]     [description]
	 */
	public function getdb()
	{
		$db = Mysql::DB();
		$list = Cache::get('article_list_all');
		if(empty($list)) {
			$list = $db->name('article')->alias('a')->leftJoin(['__ARTICLE_EXTENDS__'=>'ae'],'ae.article_id = a.article_id')
					->leftJoin(['__ARTICLE_CATEGORY__'=>'ac'],'ac.category_id = a.category_id')
					->leftJoin(['__ADMIN_USER__'=>'u'],'u.id = a.admin_id')
					->field('a.title,a.article_id,a.article_desc,a.article_type,a.category_id,a.create_time,ac.category_name,ae.is_home,ae.is_show,ae.author,ae.views_count,ae.sort,ae.tags,u.username')
					->select();	
			if(!empty($list)) Cache::set('article_list_all',$list);		
		}
		return $this->appJson($this->appResult('SUCCESS',$list,false,0));
	}
}