### 思智捷科技 refinephp 框架使用说明

- refinephp 是一款基于easyswoole的快速开发的php框架，在原有的easyswoole的基础上增强了定时器、任务投递等功能，简化了配置操作、缓存操作、路由操作、以及reqeust、response等操作的复杂性和安全性，完全兼容easyswoole内的所有方法  具体可以查看easyswoole官方文档

refinephp 常用类说明
-------------

### Controller 类
                
----
#### 命名空间：` szjcomo\szjcore\Controller ` 
                    
> 继承自 EasySwoole\Http\AbstractInterface\Controller

#### 方法列表：

|  类型 | 方法名称   | 参数说明  |  方法说明 |
| ------------ | ------------ | ------------ | ------------ |
| public  | index()  | 无  | easyswoole 规定继承自控制器必须实现index方法  |
| public  | session($key,$value)  | key,value  | 获取session和设置session的值  |
| public  | appResult($info,$data,$err)  | info,data,err  | 统一app返回值,info 返回说明 data的数据 err是否正确  |
| public  | appJson($data,$code)  |data,code  | 响应JSON数据,code默认是200  |
| public  | initialize()  |无 | 全局拦截事件，如做权限控制请在子类中自行完成，返回false不继续执行后面的程序 返回true继续执行  |
| public  | onRequest()  |无 | 重写了easyswoole的onRequest()事件，增强了context功能，不建议子类重写，子类可以实现initialize()事件即可  |
| public  | onException()  |无 | 重写了easyswoole的onException事件，如果控制器出错,统一返回json格式错误信息  |
| public  | _emtpy($action)  |action | 未请求到方法空操作设置,子类可根据业务需要自定义实现  |

#### 属性列表：

|  类型 | 属性名  |  实现方法 |  属性说明 |
| ------------ | ------------ | ------------ | ------------ |
|  Protected | $context  |  method、get等等 | 控制器请求的上下文环境 具体详情可查看下方Context类  |
|  Protected | $_session  |  set、get等等 | 原生的easyswoole的session 具体可查看官方session文档  |


### ViewController 类
                
----
#### 命名空间：` szjcomo\szjcore\ViewController `
                    
> 继承自 szjcomo\szjcore\Controller 模版引擎采用的think-template 如果您是前后端分离的项目 请直接继承Controller类 不必继承此类 只有在用到View的情况下才继承此类

####   方法列表：

|  类型 | 方法名称   | 参数说明  |  方法说明 |
| ------------ | ------------ | ------------ | ------------ |
| public  | fetch($template)  | 模版路径  | 寻找根目录下templates下的模版文件  |

#### 属性列表：

|  类型 | 属性名  |  实现方法 |  属性说明 |
| ------------ | ------------ | ------------ | ------------ |
|  Protected | $view  |  assign等等 | 具体可查看thinkphp template官方说明  |

### Cache 类
                
----
#### 命名空间：` szjcomo\szjcore\Cache `
                    
> 只适用于小型缓存系统,如有需要大量的缓存下建议用memcache 或redis  缓存类增强了get 和set方法 可批量获取或批量设置 基于内存的缓存系统 小型缓存系统中特别适合

####   方法列表：

|  类型 | 方法名称   | 参数说明  |  方法说明 |
| ------------ | ------------ | ------------ | ------------ |
| static  | get($key)  |  $key |  获取缓存,如果不传key key为数组时为批量获取 |
| static  | set($key,$value,$expire)  |  $key,$value,$expire | 设置缓存,$expire为设置过期时间，可批量设置缓存 key和value可以是为数组 value为null时删除缓存  |
| static  | del($key)  |  $key | 删除缓存  |
| static  | clear()  |  无 | 清空缓存  |
| static  | keys()  |  无 | 获取所有缓存下标  |
| static  | count()  |  无 | 获取所有缓存个数  |
| static  | getExpire($key)  |  $key | 获取一个key的过期时间  |


### Config 类
                
----
#### 命名空间：` szjcomo\szjcore\Config `
                    
> 简化了easyswoole Config的类操作 参数标准与easyswoole官方文档保持一致

####   方法列表：

|  类型 | 方法名称   | 参数说明  |  方法说明 |
| ------------ | ------------ | ------------ | ------------ |
| static  | get($key)  |  $key |  获取配置 |
| static  | set($key,$value)  |  $key,$value | 动态设置配置  |

### Context 类
                
----
#### 命名空间：` szjcomo\szjcore\Context `
                    
> 功能强大的context的类,主要是对请求的安全性的便捷性进行封装 具体使用请配合Controller的context属性使用 对easyswoole官方的request和response进行强化和整合

####   方法列表：

|  类型 | 方法名称   | 参数说明  |  方法说明 |
| ------------ | ------------ | ------------ | ------------ |
| public  | method()  |  无 |  获取本次请求的方法 |
| public  | isGet()  |  无 | 是否get请求  |
| public  | isPost()  |  无 | 是否post请求  |
| public  | isPut()  |  无 | 是否put请求  |
| public  | isDelete()  |  无 | 是否delete请求  |
| public  | put()  |  无 | 获取put请求的数据  |
| public  | uploads($inputName,$options)  |  $inputName,$options | 文件上传功能，详情请往下看  |
| public  | uploadsHandler($uploadFile,$options,$fileName)  |  $uploadFile,$options,$fileName | 文件上传处理,如果uploads方法不能满足时可直接调用此方法  |
| public  | getFileNameExt($fileName)  | $fileName | 获取文件名后缀  |
| public  | get($key,$default,$filter)  | $key,$default,$filter | 获取get请求参数 如果key获取为空或不存，直接返回$default的值，第三个参数为过滤函数  |
| public  | post($key,$default,$filter)  | $key,$default,$filter | 获取post请求参数 如果key获取为空或不存，直接返回$default的值，第三个参数为过滤函数  |
| public  | param($key,$default,$filter)  | $key,$default,$filter | 获取get/post请求参数 如果key获取为空或不存，直接返回$default的值，第三个参数为过滤函数  |
| public  | getip()  | 无 | 可获取远程用户IP  |
| public  | cookie($key,$value,$expire)  | $key,$value,$expire | 获取或设置cookie  |
| public  | header($name,$value)  | $key,$value | 获取或设置header头信息  |
| public  | redirect($url)  | $url | 重定向  |
| public  | _servers()  | 无| $_SERVER |

### Task 类
                
----
#### 命名空间：` szjcomo\szjcore\Task `
                    
> 继承自AbstractAsyncTask,使用该类必须是任务模版类型，如果需要使用简单的类,可以直接使用callable的简单投递任务的方式 具体请查看官方文档,该类主要是增强了官方的任务投递过程中不能传递参数限制，使用本类可以传递参数以及简化了任务投递的复杂性 但本类不支持finish方法 因为个人觉得必要性不大,本类为异步任务的实现 如果需要同步任务 请查看官方文档

####   方法列表：

|  类型 | 方法名称   | 参数说明  |  方法说明 |
| ------------ | ------------ | ------------ | ------------ |
| static  | addTask($callback,$params,$className)  | $callback,$params,$className |  $callback 是回调方法名称 string $params是参数 默认数组为空 $callName 是任务回调类名称 默认为\App\common\ExtendsCallback string类型 |

#### 属性列表：

|  类型 | 属性名  |  实现方法 |  属性说明 |
| ------------ | ------------ | ------------ | ------------ |
|  static | $callbackClass  |  无(自行实现) | 因为静态属性，如果您需要指定类,建议在addTask中指定$className，这样能保证全局不会乱  |


### Times 类
                
----
#### 命名空间：` szjcomo\szjcore\Timers `
                    
> 定时器类，增强了官方的定时器功能，简化了定时器操作复杂性，也支持定时中参数传递,其它看提供的方法就可以知道 与javascript中的定时器用法一样 函数名一样 主要是方便使用

####   方法列表：

|  类型 | 方法名称   |   方法说明 |
| ------------ | ------------ | ------------ |
| static  | setInterval($callback = null,$microSeconds = 5000,$params = [],$callbackClass = null)  |   $callback 是回调方法名称 可以为一个函数或函数名称 $microSeconds操作时间以毫称为单位 默认5000 $params 需要传递的参数  $callbackClass默认为\App\common\ExtendsCallback string类型，此方法返回一个定时器ID 无限执行 |
| static  | clearInterval($tmId)  | 清除一个定时器   |
| static  | setTimeout($callback = null,$microSeconds = 5000,$params = [],$callbackClass = null)  | 参数和用法与setInterval一致 请查看setInterval说明 只执行一次   |

#### 属性列表：

|  类型 | 属性名  |  实现方法 |  属性说明 |
| ------------ | ------------ | ------------ | ------------ |
|  static | $callbackClass  |  无(自行实现) | 因为静态属性，如果您需要指定类,建议在定时器$callbackClass参数中指定，这样能保证全局不会乱  |

### Mysql 类
                
----
#### 命名空间：` szjcomo\szjcore\Mysql `
                    
> 封装了一个DB方法 和table方法 主要是简化写代码量 其它与easyswoole保持一致 也是线程池操作

####   方法列表：

|  类型 | 方法名称   | 参数说明  |  方法说明 |
| ------------ | ------------ | ------------ | ------------ |
| static  | DB()  |  无 |  返回一个mysql可用的线程池链接，并自动进行回收 |
| static  | table($tableName)  |  $tableName | 增加数据库配置前缀 别的没什么操作，也可不使用自己手工指定  |
