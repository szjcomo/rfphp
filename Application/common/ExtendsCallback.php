<?php
/**
 * |-----------------------------------------------------------------------------------
 * @Copyright (c) 2014-2018, http://www.sizhijie.com. All Rights Reserved.
 * @Website: www.sizhijie.com
 * @Version: 思智捷信息科技有限公司
 * @Author : szjcomo 
 * |-----------------------------------------------------------------------------------
 */
namespace App\common;

use szjcomo\phpwechat\Wechat;

/**
 * 扩展功能,更多应用可自由发挥
 * 当前可应用于 任务扩展 定时扩展
 */
class ExtendsCallback 
{
	/**
	 * [sendMail 定时发送邮件]
	 * @Author    como
	 * @DateTime  2019-08-10
	 * @copyright 思智捷管理系统
	 * @version   [1.5.0]
	 * @return    [type]     [description]
	 */
	public static function sendMail($data = [])
	{
		echo '执行邮件发送功能';
		print_r($data);
	}
	/**
	 * [sendCustomer 回复客服消息处理]
	 * @author szjcomo
	 * @DateTime 2019-09-07T17:16:56+0800
	 * @return   [type]                   [description]
	 */
	public static function sendCustomer($data = [])
	{
		$access_token = '25_mu-YzOijVtnAWxiub9GSZlPwJg_fWfjhL_ZVMUOlxkDF5W2BU80ONJp3gkeinKN_5cK4GksfRwmN8FHidaGXS_zUNnRwerzJLFXSGscvJxZ_k9ciY6BTZt3nVb4D_7xk3HT3y2BBMBxVuNiyYLKdAFAOBA';
		$options = [
			'touser'=>$data['openid'],'msgtype'=>'text',
			'text'=>['content'=>'思智捷信息科技客服为您服务'."\r\n".'您好 请问下有什么可以帮您?']
		];
		Wechat::customer($access_token,$options,'message');
	}
}