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
Class Index extends Base {
	/**
	 * [$extendsClass 指定微信通知回调类]
	 * @var string
	 */
	Protected $extendsClass 	= '\App\common\WeixinExtends';
	/**
	 * [$extendsCallback 统一的消息回复回调函数]
	 * @var string
	 */
	Protected $extendsCallback 	= 'callback';
	/**
	 * [entry 微信通信入口]
	 * @author szjcomo
	 * @DateTime 2019-09-02T10:40:57+0800
	 * @return   [type]                   [description]
	 */
	Public function entry(){
		///$token = baseWechat::getAccessToken('wxaa87568b97b2abc1','57a0c75ef9bbe24f65ebae9846e243f0');
		//print_r($token);
		$echostr = $this->context->get('echostr','');
		if(!empty($echostr))
			return $this->response()->write(baseWechat::checkSignature(self::getToken(),$this->context));
		else 
			return $this->response()->write($this->wxMessage());
	}

	Public function tmp(){
		$access_token = '25_qxJE5tGelTvVOvDrAMzIWnVmcruEIH2eOeGk0P3KUvEstyD22TnCHbR9T-N0kjHdi-b-6Dn_hg6AZDomIzkhCGl_OjTUgfloLFKNT6ftj6_udLRJJrGcHurW25iPpddxcmjT-unJrPlnia1tYHYbABABKB';
		$data = [
			'touser'=>'oSF4duIAfTLdEMukzNOpYPAuJxEo',
			'template_id'=>'0lVAeJntZFHi950PI-iHl08Fo2Uuoa3P2Hx_DRofbqg',
			'url'=>'http://www.sizhijie.com',
	        /*"miniprogram"=>[
	            "appid"=>"wx286b93c14bbf93aa",
	            "pagepath"=>"pages/lunar/index"
	        ],  */
			"data"=>[
				'name'=>['value'=>'罗勇','color'=>'#173177'],
				'remark'=>['value'=>'皮鞋100元','color'=>'#ff0000']
			]
		];
		$result = baseWechat::template($access_token,$data,'message');
		return $this->appJson($result);
	}




	/**
	 * [getToken 获取配置的token]
	 * @author szjcomo
	 * @DateTime 2019-09-02T11:09:37+0800
	 * @return   [type]                   [description]
	 */
	Protected static function getToken(){
		return 'szjcomo2019';
	}
	/**
	 * [wxMessage 响应微信消息]
	 * @author szjcomo
	 * @DateTime 2019-09-02T11:08:43+0800
	 * @return   [type]                   [description]
	 */
	Protected function wxMessage(){
		$result = baseWechat::start($this->context);
		if($result['err'] == false){
			return baseWechat::run($this->extendsClass,$this->extendsCallback,$result['data']);
		} else {
			Logger::getInstance()->error($result['info']);
		}
	}

}