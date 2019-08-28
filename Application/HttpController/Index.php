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
use szjcomo\szjcore\Task;
use szjcomo\szjcore\Timers;
use szjcomo\szjcore\Mysql;
use szjcomo\szjcore\Cache;
use App\controller\Base;
/**
 * 自定义控制器
 */
Class Index extends Base {
	/**
	 * [index 首页访问]
	 * @Author    como
	 * @DateTime  2019-08-09
	 * @copyright 思智捷管理系统
	 * @version   [1.5.0]
	 * @return    [type]     [description]
	 */
	Public function index(){
		//return $this->context->redirect('/Index/postindex');
		$ip = $this->context->getip();
		$this->view->assign(['uname'=>'河源思智捷信息科技有限公司szjcomo','ip'=>$ip]);
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
	Protected function adddata(){
		try{
			$enrollName = Mysql::table('enroll').' as e';
			$gaidName = Mysql::table('graduate_area').' as ga';
			$gtidName = Mysql::table('graduate_time').' as gt';
			$sname    = Mysql::table('specialty').' as s';
			$sname1    = Mysql::table('specialty').' as ss';
			$field = 'e.eid,e.uname,s.name as sname,e.address,e.born,e.idcardno,e.sex,e.nation,e.call_phone,e.stu_no,e.class_num,e.pay_money,e.is_pay,e.pay_type,e.out_trade_no,e.order_number,e.source_port,e.father_name,e.father_phone,e.is_del,e.add_admin,e.add_time,e.pay_time,e.flag,ga.ga_name,gt.gt_name,e.remarks,s.class_name,ss.name as pname';
			$data = Mysql::DB()->join($gaidName,'ga.ga_id = e.ga_id')
					->join($gtidName,'gt.gt_id = e.gt_id')
					->join($sname,'s.sid = e.sid')
					->join($sname1,'ss.sid = s.pid')
					->get($enrollName,10,$field);
			if(!empty($data)){
				//$this->adddata($data);
				$result = $this->appResult('SUCCESS',$data,false);
			} else {
				$result = $this->appResult('not data');
			}
		} catch(\Exception $err){
			$result = $this->appResult($err->getMessage());
		}
		return $result;
	}



	/**
	 * [postindex 响应Post请求]
	 * @Author    como
	 * @DateTime  2019-08-12
	 * @copyright 思智捷管理系统
	 * @version   [1.5.0]
	 * @return    [type]     [description]
	 */
	Public function postindex(){
		$insertData = Cache::get('insertdata');
		if(empty($insertData)){
			echo 123;
			$result = $this->adddata();
			if($result['err'] == false){
				$insertData = $result['data'];
				$id = Cache::set('insertdata',$result['data']);
				echo 'id'.$id.PHP_EOL;
			}
		}

        //$this->session('userinfo',['username'=>'szjcomo','role_id'=>0]);


		//var_dump($this->session('userinfo'));

		//$result = \App\core\Excel::import('./static/test.xlsx');
		//Task::addTask('exportEnroll',$insertData);

		//Mysql::DB()->insertMulti(Mysql::table('test1'),$insertData);
		return $this->appJson($insertData);
	}



}