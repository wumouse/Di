<?php
/**
 * breakfast_service.
 *
 * @author Haow1 <haow1@jumei.com>
 * @version $Id$
 */

namespace Di\Sample;

/**
 * 注入服务
 *
 * @package Library\Sample
 */
class Service
{
    /**
     * 服务名
     *
     * @var string
     */
    protected $name;

    /**
     * 定义
     *
     * @var mixed
     */
    protected $definition;

    /**
     * 共享的服务
     *
     * @var self
     */
    protected $sharedInstance;

    /**
     * 是否共享
     *
     * @var bool
     */
    private $shared;

    /**
     * @param string $name 名称
     * @param mixed $definition 定义,匿名函数,或类名,或对象
     * @param bool $shared 是否共享
     */
    public function __construct($name, $definition, $shared = false)
    {
        $this->name = $name;
        $this->definition = $definition;
        $this->shared = $shared;
    }

    /**
     * 分解
     *
     * @param array $params 参数
     * @return object
     */
    public function resolve(array $params = null)
    {
        if ($this->shared && $this->sharedInstance) {
            return $this->sharedInstance;
        }

        if (is_callable($this->definition)) {
            !$params && $params = array();
            $instance = call_user_func_array($this->definition, $params);
        } elseif (class_exists($this->definition)) {
            $instance = new $this->definition;
        } else {
            $instance = $this->definition;
        }

        $this->sharedInstance = $instance;

        return $instance;
    }
}
