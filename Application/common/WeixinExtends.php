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

use szjcomo\szjcore\Task;

/**
 * 扩展微信通信功能
 */
class WeixinExtends 
{
	/**
	 * [callback 回调函数]
	 * @author szjcomo
	 * @DateTime 2019-09-03T14:26:23+0800
	 * @param    array                    $req [description]
	 * @return   function                      [description]
	 */
	public static function callback(array $req = []):array
	{
		$result = self::wxResult('未查询到相关的消息内容');
		$data = self::toCusStruct($req);
		switch($data['type']){
			case 'event':
				$result = self::eventMessage($data);
				break;
			default:
				$result = self::contentMessage($data);
		}
		return $result;
	}
	/**
	 * [wxResult 微信统一返回格式]
	 * @author szjcomo
	 * @DateTime 2019-09-03T14:36:26+0800
	 * @param    [type]                   $data [可以为字符串/数组]
	 * @param    string                   $type [text/image/news/video/voice]
	 * @return   [type]                         [description]
	 */
	public static function wxResult($data = null,string $type = 'text'):array
	{
		return ['type'=>$type,'data'=>$data];
	}
	/**
	 * [eventMessage 事件消息]
	 * @author szjcomo
	 * @DateTime 2019-09-03T14:47:57+0800
	 * @param    array                    $data [description]
	 * @return   [type]                         [description]
	 */
	public static function eventMessage(array $data = []):array
	{
		$result = self::wxResult('事件类消息回复');
		switch($data['event']){
			case 'click':
				$result = self::clickCallback($data);
				break;
			case 'view':
				$result = self::wxResult('用户自定义菜单链接事件,事件值是:'.$data['eventkey']);
				break;
			case 'location':
				$result = self::wxResult('用户上报地理位置事件,事件值是'.$data['latitude'].$data['longitude']);
				break;
			case 'scan':
				$result = self::wxResult('用户扫码已关注时的事件推送,事件值是'.$data['eventkey']);
				break;
			case 'subscribe':
				$result = self::wxResult('用户首次关注时事件推送,事件值是');
				break;
			case 'unsubscribe':
				$result = self::wxResult('用户取消关注时事件推送,事件值是未知');
				break;
			case 'templatesendjobfinish':
				$result = self::wxResult('发送模版消息成功后回调通知');
				break;
			case 'qualification_verify_success':
				$result = self::wxResult('微信公众号资质认证成功');
				break;
			case 'qualification_verify_fail':
				$result = self::wxResult('微信公众号资质认证失败');
				break;
			case 'naming_verify_success':
				$result = self::wxResult('名称认证成功（即命名成功）');
				break;
			case 'naming_verify_fail':
				$result = self::wxResult('名称认证失败（这时虽然客户端不打勾，但仍有接口权限）');
				break;
			case 'annual_renew':
				$result = self::wxResult('提醒公众号需要去年审了');
				break;
			case 'verify_expired':
				$result = self::wxResult('认证过期失效通知审通知');
				break;
			case 'kf_create_session':
				$result = self::wxResult('与客服建立会话成功');
				break;
			case 'kf_close_session':
				$result = self::wxResult('用户退出与客服会话');
				break;
			default:
				$result = self::wxResult('未知的事件类型,未处理');
		}
		return $result;
	}
	/**
	 * 点击事件回调函数
	 * @author szjcomo
	 * @DateTime 2019-09-07T15:49:11+0800
	 * @param    array                    $data [description]
	 * @return   [type]                         [description]
	 */
	public static function clickCallback(array $data):array
	{
		$key = $data['eventkey'];
		switch($key){
			case 'szjkf':
				$result = self::szjkfCallback($data);
				break;
			default:
				$result = self::wxResult('系统提醒：对不起,['.$key.']的值暂未查询相关的回复消息');
				break;
		}
		return $result;
	}
	/**
	 * [szjkfCallback 思智捷客服系统]
	 * @author szjcomo
	 * @DateTime 2019-09-07T15:50:15+0800
	 * @param    array                    $data [description]
	 * @return   [type]                         [description]
	 */
	public static function szjkfCallback(array $data):array
	{
		$result = self::wxResult('szj@l15219840108','transfer_customer_service');
		Task::addTask('sendCustomer',$data);
		return $result;
	}

	/**
	 * [Message 公众号内容发送的消息]
	 * @author szjcomo
	 * @DateTime 2019-09-03T14:48:38+0800
	 * @param    array                    $data [description]
	 */
	public static function contentMessage(array $data = []):array
	{
		$result = self::wxResult('用户发送消息类');
		switch ($data['type']) {
			case 'text':
				$result = self::wxResult('用户发送文本消息'.$data['text']);
				break;
			case 'image':
				$result = self::wxResult('用户发送图片消息'.$data['mediaid']);
				break;
			case 'voice':
				$result = self::wxResult('用户发送语音消息'.$data['mediaid']);
				break;
			case 'video':
				$result = self::wxResult('用户发送视频消息'.$data['thumbMediaid']);
				break;
			case 'link':
				$result = self::wxResult('用户发送链接类消息'.$data['url']);
				break;
			case 'location':
				$result = self::wxResult('用户发送地理位置消息'.json_encode($data));
				break;
			default:
				# code...
				break;
		}
		return $result;
	}


	/**
	 * [toCusStruct 转化成自定义的结构]
	 * @author szjcomo
	 * @DateTime 2019-09-03T14:53:00+0800
	 * @param    array                    $req [description]
	 * @return   [type]                        [description]
	 */
	public static function toCusStruct(array $req = []):array
	{
		$type = $req['MsgType'];
		$params = ['openid'=>$req['FromUserName'],'type'=>$type];
		switch($type){
			case 'text':
				$params['text'] = $req['Content'];
				break;
			case 'image':
				$params['picurl']  = $req['PicUrl'];
				$params['mediaid'] = $req['MediaId'];
				break;
			case 'voice':
				$params['mediaid'] = $req['MediaId'];
				$params['format'] = $req['Format'];
				break;
			case 'video':
				$params['mediaid'] = $req['MediaId'];
				$params['thumbMediaid'] = $req['ThumbMediaId'];
				break;
			case 'location':
				$params['location_x'] = $req['Location_X'];
				$params['location_y'] = $req['Location_Y'];
				$params['scale'] 	= $req['Scale'];
				$params['label'] 	= $req['Label'];
				break;
			case 'link':
				$params['title'] = $req['Title'];
				$params['description'] = $req['Description'];
				$params['url'] = $req['Url'];
				break;
			case 'event':
				$params['event'] = strtolower($req['Event']);
				if(isset($req['EventKey']))
					$params['eventkey'] = $req['EventKey'];
				if(isset($req['Ticket']))
					$params['ticket'] = $req['Ticket'];
				if(isset($req['Latitude']))
					$params['latitude'] = $req['Latitude'];
				if(isset($req['Longitude']))
					$params['longitude'] = $req['Longitude'];
				if(isset($req['Precision']))
					$params['precision'] = $req['Precision'];
				if(isset($req['Status']))
					$params['status'] = $req['Status'];
				break;
		}
		return $params;
	}
}



