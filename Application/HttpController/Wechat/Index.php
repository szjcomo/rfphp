<?php
/**
*-----------------------------------------------------------------------------------
////////////////////////////////////////////////////////////////////
//                          _ooOoo_                               //
//                         o8888888o                              //
//                         88" . "88                              //
//                         (| ^_^ |)                              //
//                         O\  =  /O                              //
//                      ____/`---'\____                           //
//                    .'  \|     |//  `.                         //
//                   /  \|||  :  |||//  \                        //
//                  /  _||||| -:- |||||-  \                       //
//                  |   | \\  -  /// |   |                       //
//                  | \_|  ''\---/''  |   |                       //
//                  \  .-\__  `-`  ___/-. /                       //
//                ___`. .'  /--.--\  `. . ___                     //
//            \  \ `-.   \_ __\ /__ _/   .-` /  /                 //
//      ========`-.____`-.___\_____/___.-`____.-'========         //
//                           `=---='                              //
//      ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^        //
//         佛祖保佑       永无BUG       永不修改                    //
////////////////////////////////////////////////////////////////////
* @Copyright 思智捷科技(c) this is a snippet.
* @Website: www.sizhijie.com
* @Author : szjcomo 
*-----------------------------------------------------------------------------------
*/

namespace App\HttpController\Wechat;

use App\controller\Base;
use szjcomo\phpwechat\Wechat as baseWechat;
use EasySwoole\EasySwoole\Logger;

/**
 * 微信通知接口控制器
 */
class Index extends Base 
{
	/**
	 * [$extendsClass 指定微信通知回调类]
	 * @var string
	 */
	protected $extendsClass 	= '\App\common\WeixinExtends';
	/**
	 * [$extendsCallback 统一的消息回复回调函数]
	 * @var string
	 */
	protected $extendsCallback 	= 'callback';
	/**
	 * [entry 微信通信入口]
	 * @author szjcomo
	 * @DateTime 2019-09-02T10:40:57+0800
	 * @return   [type]                   [description]
	 */
	public function entry()
	{
		$echostr = $this->context->get('echostr','');
		if(!empty($echostr)) return $this->response()->write(baseWechat::checkSignature(self::getToken(),$this->context));
		return $this->response()->write($this->wxMessage());
	}

	/**
	 * [getAccessToken 获取access_token]
	 * @author szjcomo
	 * @DateTime 2019-09-05T14:12:30+0800
	 * @return   [type]                   [description]
	 */
	protected function getAccessToken()
	{
		//思智捷服务
		$appid = 'xxx';
		$secret = 'xxx';
		$res = baseWechat::getAccessToken($appid,$secret,true);
		print_r($res);
		if ($res['err'] == false){
			return $res['data']['access_token'];
		}
		return '';
	}

	/**
	 * [getToken 获取配置的token]
	 * @author szjcomo
	 * @DateTime 2019-09-02T11:09:37+0800
	 * @return   [type]                   [description]
	 */
	protected static function getToken()
	{
		return 'szjcomo2019';
	}
	/**
	 * [wxMessage 响应微信消息]
	 * @author szjcomo
	 * @DateTime 2019-09-02T11:08:43+0800
	 * @return   [type]                   [description]
	 */
	protected function wxMessage()
	{
		$result = baseWechat::start($this->context);
		if($result['err'] == false){
			return baseWechat::run($this->extendsClass,$this->extendsCallback,$result['data']);
		} else {
			Logger::getInstance()->error($result['info']);
		}
	}

}