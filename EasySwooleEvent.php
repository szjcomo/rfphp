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

namespace EasySwoole\EasySwoole;

use EasySwoole\EasySwoole\Swoole\EventRegister;
use EasySwoole\EasySwoole\AbstractInterface\Event;
use EasySwoole\Http\Request;
use EasySwoole\Http\Response;
use EasySwoole\FastCache\Cache;
use szjcomo\szjcore\CacheExtends;
use EasySwoole\Utility\File;
use EasySwoole\Component\Di;
/*数据库*/
use EasySwoole\EasySwoole\Config as GConfig;
use szjcomo\mysqliPool\Mysql;
use szjcomo\mysqli\Config as MysqlConfig;
/*redis*/
use EasySwoole\RedisPool\Config as RedisConfig;
use EasySwoole\RedisPool\Redis;
/*ip限流*/
use szjcomo\szjcore\Iplimit;
use EasySwoole\Component\Process\AbstractProcess;
use szjcomo\szjcore\HotReload;

class EasySwooleEvent implements Event
{
    /**
     * [$iplimitopen 是否开启IP限流]
     * @var boolean
     */
    protected static $iplimitopen = null;
    /**
     * [$crossDomain 是否开启可以跨域请求]
     * @var boolean
     */
    protected static $crossDomain = false;
    /**
     * [initialize 全局初始化事件]
     * @Author    como
     * @DateTime  2019-08-15
     * @copyright 思智捷管理系统
     * @version   [1.5.0]
     * @return    [type]     [description]
     */
    public static function initialize()
    {
        // TODO: Implement initialize() method.
        date_default_timezone_set('Asia/Shanghai');
        //注册自定义配置
        self::registerCusConfig();
        //注册mysql
        self::registerMysql();
        //注册redis
        self::registerRedis();
    }
    /**
     * [mainServerCreate 全局服务器创建事件]
     * @Author    como
     * @DateTime  2019-08-15
     * @copyright 思智捷管理系统
     * @version   [1.5.0]
     * @param     EventRegister $register [description]
     * @return    [type]                  [description]
     */
    public static function mainServerCreate(EventRegister $register)
    {
        // TODO: Implement mainServerCreate() method.
        //注册缓存类
        self::registerFastCache();
        //拦截IP高访问的流
        self::registerIpLimitProcess();
        //跨域请求处理
        self::$crossDomain = GConfig::getInstance()->getConf('cross_domain');
        //开启热重载检查
        self::projectReloadListen();
    }


    /**
     * [onRequest 全局请求事件]
     * @Author    como
     * @DateTime  2019-08-15
     * @copyright 思智捷管理系统
     * @version   [1.5.0]
     * @param     Request    $request  [description]
     * @param     Response   $response [description]
     * @return    [type]               [description]
     */
    public static function onRequest(Request $request, Response $response): bool
    {
        //跨域处理
        if(self::$crossDomain){
            $response->withHeader('Access-Control-Allow-Origin', '*');
            $response->withHeader('Access-Control-Allow-Methods', 'GET, POST');
            $response->withHeader('Access-Control-Allow-Credentials', 'true');
            $response->withHeader('Access-Control-Allow-Headers', 'Content-Type, Authorization, X-Requested-With');       
        }
        //ip拦截器
        return self::registerIpLimit($request);
    }


    /**
     * [afterRequest 全局请求完成事件]
     * @Author    como
     * @DateTime  2019-08-15
     * @copyright 思智捷管理系统
     * @version   [1.5.0]
     * @param     Request    $request  [description]
     * @param     Response   $response [description]
     * @return    [type]               [description]
     */
    public static function afterRequest(Request $request, Response $response): void
    {
        // TODO: Implement afterAction() method.
    }

    /********************************用户自定义全局功能***********************************/

    /**
     * [registerRedis 是否开始redis功能]
     * @Author   szjcomo
     * @DateTime 2019-09-26
     * @return   [type]     [description]
     */
    protected static function registerRedis()
    {
        $is_redis_register = GConfig::getInstance()->getConf('is_redis_register');
        if($is_redis_register){
            $configData = GConfig::getInstance()->getConf('REDIS');
            foreach($configData as $key=>$val){
                $config = new RedisConfig($val);
                $poolConf = Redis::getInstance()->register('redis'.$key,$config);
                $poolConf->setMaxObjectNum($val['maxObjectNum']);
                $poolConf->setMinObjectNum($val['minObjectNum']);            
            }            
        }
    }

    /**
     * [projectReloadListen 是否需要开启项目热重载监听]
     * @Author   szjcomo
     * @DateTime 2019-09-26
     * @return   [type]     [description]
     */
    protected static function projectReloadListen()
    {
        $is_start = GConfig::getInstance()->getConf('hot_reload_start');
        if($is_start === true){
            $options = GConfig::getInstance()->getConf('hot_reload_config');
            //注册热启动
            ServerManager::getInstance()->getSwooleServer()->addProcess((new HotReload('HotReload', $options))->getProcess());
        }
    }
    /**
     * [registerIpLimitProcess 注册自定义进程定时清除拦籍的ip]
     * @Author    como
     * @DateTime  2019-08-15
     * @copyright 思智捷管理系统
     * @version   [1.5.0]
     * @return    [type]     [description]
     */
    protected static function registerIpLimitProcess()
    {
        if(is_null(self::$iplimitopen)){
            self::$iplimitopen = GConfig::getInstance()->getConf('iplimit_open');
        }
        if(self::$iplimitopen){
            // 开启IP限流
            Iplimit::getInstance();
            $class = new class('IpAccessCount') extends AbstractProcess{
                protected function run($arg){
                    $this->addTick(5*1000, function (){
                        Iplimit::getInstance()->clear();
                    });
                }
            };
            ServerManager::getInstance()->getSwooleServer()->addProcess(($class)->getProcess());
        }
    }

    /**
     * [registerIpLimit 开启IP限流拦截功能]
     * @Author    como
     * @DateTime  2019-08-15
     * @copyright 思智捷管理系统
     * @version   [1.5.0]
     * @return    [type]     [description]
     */
    protected static function registerIpLimit($request)
    {
        if(is_null(self::$iplimitopen)){
            self::$iplimitopen = GConfig::getInstance()->getConf('iplimit_open');
        }
        if(self::$iplimitopen){
            $fd = $request->getSwooleRequest()->fd;
            $ip = ServerManager::getInstance()->getSwooleServer()->getClientInfo($fd)['remote_ip'];
            $iplimitconfig = GConfig::getInstance()->getConf('iplimit_secode');
            if (Iplimit::getInstance()->access($ip) > $iplimitconfig) {
                ServerManager::getInstance()->getSwooleServer()->close($fd);
                return false;
            } else {
                return true;
            }            
        }
        return true;
    }

    /**
     * [registerFastCache 注册缓存事件]
     * @Author    como
     * @DateTime  2019-08-15
     * @copyright 思智捷管理系统
     * @version   [1.5.0]
     * @return    [type]     [description]
     */
    protected static function registerFastCache(){
        $isopen = GConfig::getInstance()->getConf('fast_cache_open');
        if($isopen === true) {
            $config = GConfig::getInstance()->getConf('fast_cache_config');
            CacheExtends::run($config);
            Cache::getInstance()->setTempDir(EASYSWOOLE_TEMP_DIR)->attachToServer(ServerManager::getInstance()->getSwooleServer());
        }
    }

    /**
     * [registerMysql 注册mysql功能]
     * @Author    como
     * @DateTime  2019-08-14
     * @copyright 思智捷管理系统
     * @version   [1.5.0]
     * @return    [type]     [description]
     */
    protected static function registerMysql()
    {
        $configData = GConfig::getInstance()->getConf('MYSQL');
        foreach($configData as $key=>$val){
            $config     = new MysqlConfig($val);
            $poolConf   = Mysql::getInstance()->register('mysql'.$key,$config);
            $poolConf->setMaxObjectNum($val['maxconn']);
            $poolConf->setMinObjectNum($val['minconn']);            
        }
    }

    /**
     * [registerCusConfig 注册自定义配置文件功能]
     * @Author    como
     * @DateTime  2019-08-14
     * @copyright 思智捷管理系统
     * @version   [1.5.0]
     * @return    [type]     [description]
     */
    protected static function registerCusConfig()
    {
        //加载自定义配置文件
        self::loadConf(EASYSWOOLE_ROOT . '/config');
        //获取自定义pool最大链接数
        $POOL_MAX_NUM = Config::getInstance()->getConf('HTTP_CONTROLLER_POOL_MAX_NUM');
        //http控制器对象池最大数量
        Di::getInstance()->set(SysConst::HTTP_CONTROLLER_POOL_MAX_NUM,$POOL_MAX_NUM);
    }

    /**
     * [loadConf 自定义方法 加载自定义配置文件]
     * @Author    como
     * @DateTime  2019-08-15
     * @copyright 思智捷管理系统
     * @version   [1.5.0]
     * @param     [type]     $ConfPath [description]
     * @return    [type]               [description]
     */
    public static function loadConf($ConfPath)
    {
        $Conf  = Config::getInstance();
        $datas = File::scanDirectory($ConfPath);
        if (empty($datas) || empty($datas['files']) || !is_array($datas['files']))  return;
        foreach ($datas['files'] as $file) $Conf->loadFile($file,true);
    }
}