### 思智捷科技 refinephp 框架使用说明

- refinephp 是一款基于easyswoole的快速开发的php框架，在原有的easyswoole的基础上增强了定时器、任务投递等功能，简化了配置操作、缓存操作、路由操作、以及reqeust、response等操作的复杂性

refinephp 常用类说明
-------------

### Controller
                
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


### ViewController
                
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


