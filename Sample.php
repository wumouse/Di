<?php
/**
 * breakfast_service.
 *
 * @author Haow1 <haow1@jumei.com>
 * @version $Id$
 */

namespace Di;

use Di\Sample\Service;

/**
 * 简单的依赖注入
 *
 * <code>
 * use Di\Sample as Di;
 *
 * $di = new Di;
 * $di->set('db', function () {
 *     $db = new Db(array(
 *          'host' => '127.0.0.1',
 *          <...>
 *     ));
 *     return $db;
 * }, true);
 *
 * $db = $di->get('db');
 *
 * $di = Di::getDefault();
 * </code>
 *
 * @package Di
 */
class Sample
{
    /**
     * 服务集合
     *
     * @var Service[]
     */
    protected $services = array();

    /**
     * 实例自己
     *
     * @var self
     */
    protected static $instance;

    /**
     * 保存默认实例
     */
    public function __construct()
    {
        if (!self::$instance) {
            self::$instance = $this;
        }
    }

    /**
     * 设置服务
     *
     * @param string $name
     * @param mixed $definition 定义,支持类名,匿名函数
     * @param bool $shared 是否作为共享服务
     */
    public function set($name, $definition, $shared = false)
    {
        $this->services[$name] = new Service($name, $definition, $shared);
    }

    /**
     * 设置共享服务,与 set方法第三个参数位true 的别名
     *
     * @param string $name
     * @param mixed $definition
     */
    public function setShared($name, $definition)
    {
        $this->set($name, $definition, true);
    }

    /**
     * 获取服务
     *
     * @param string $name
     * @param array $params
     * @return object
     * @throws Exception
     */
    public function get($name, array $params = null)
    {
        if (!isset($this->services[$name])) {
            throw new Exception("The service $name not found");
        }

        return $this->services[$name]->resolve($params);
    }

    /**
     * 获取默认的依赖注入
     *
     * @return self
     */
    public static function getDefault()
    {
        return self::$instance;
    }

    /**
     * 设置默认Di
     *
     * @param Sample $instance
     */
    public static function setDefault(Sample $instance)
    {
        self::$instance = $instance;
    }

    /**
     * 重设默认的Di
     */
    public static function reset()
    {
        self::$instance = null;
    }

    /**
     * 检查是否存在某个服务
     *
     * @param string $name
     * @return bool
     */
    public function has($name)
    {
        return isset($this->services[$name]);
    }

    /**
     * 获取所有的服务对象
     *
     * @return Sample\Service[]
     */
    public function getServices()
    {
        return $this->services;
    }
}
