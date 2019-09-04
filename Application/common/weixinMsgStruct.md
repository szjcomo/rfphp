* 以下消息请自己实现回复
 * 统一回复的方法请调用wxResult
 * 消息结构演示说明
 * 		event 事件消息结构
 * 			click事件结构
				Array
				(
				    [openid] => oSF4duIAfTLdEMukzNOpYPAuJxEo
				    [type] => event
				    [event] => click
				    [eventkey] => V1001_GOOD
				)
			view事件结构 和 小程序跳转事件结构未收到
			unsubscribe 用户取消关注事件结构
				Array
				(
				    [openid] => oSF4duIAfTLdEMukzNOpYPAuJxEo
				    [type] => event
				    [event] => unsubscribe
				    [eventkey] => Array
				        (
				        )

				)
			subscribe  用户关注公众号事件结构
				Array
				(
				    [openid] => oSF4duIAfTLdEMukzNOpYPAuJxEo
				    [type] => event
				    [event] => subscribe
				    [eventkey] => Array()

				)

 *  	text 文本消息
			Array
			(
			    [openid] => oSF4duIAfTLdEMukzNOpYPAuJxEo
			    [type] => text
			    [text] => 123
			)
 *  	image 图片消息
			Array
			(
			    [openid] => oSF4duIAfTLdEMukzNOpYPAuJxEo
			    [type] => image
			    [picurl] => http://mmbiz.qpic.cn/mmbiz_jpg/
			    [mediaid] => BK8Jw9yYp4U45P4itmzBQkR2Ei_NtoF7t4IYxttvxiyIcPEpCw0x98AvjsTaqfgE
			)
		location 地理位置消息
			Array
			(
			    [openid] => oSF4duIAfTLdEMukzNOpYPAuJxEo
			    [type] => location
			    [location_x] => 23.759798
			    [location_y] => 114.691093
			    [scale] => 16
			    [label] => 永福羽毛球馆(河源市源城区永福西路8号)
			)
		link 链接消息结构
			Array
			(
			    [openid] => oSF4duIAfTLdEMukzNOpYPAuJxEo
			    [type] => link
			    [title] => 马云、刘强东、马化腾，这些大佬的第一桶金是怎么来的？
			    [description] => 曾几何时，大佬们也跟我们一样，是个普通人！
			    [url] => http://mp.weixin.qq.com/s?__biz=MzAxMTgzNDc0NQ==&mid=2929632730&idx=2&sn=ae2d4a982af9e9e7ad61fb7695d01199&chksm=b0d101cc87a688daf999355f41342fd227ee61fa4ad6423c7d6c50f7dfe325dd729baa8a88aa&scene=0&xtrack=1#rd
			)
		voice 语音消息结构
			Array
			(
			    [openid] => oSF4duIAfTLdEMukzNOpYPAuJxEo
			    [type] => voice
			    [mediaid] => wUFFQ9J6L0GujnudwmETOsXynVBA2OtYkwQ91NBsHbJkuAzIVn41jTWk_QdgARxW
			    [format] => amr
			)
