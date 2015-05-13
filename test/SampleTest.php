<?php
/**
 * di.
 *
 * @author Haow1 <haow1@jumei.com>
 * @version $Id$
 */

namespace Test;

use Di\Sample;

require '../Sample.php';
require '../Sample/Service.php';

/**
 * 依赖注入管理测试
 *
 * @todo 待完善
 */
class SampleTest extends \PHPUnit_Framework_TestCase
{
    /**
     * 依赖注入
     *
     * @var Sample
     */
    protected $di;

    protected function setUp()
    {
        $this->di = new Sample();
    }

    protected function tearDown()
    {
        $this->di = null;
    }

    /**
     * 测试默认DI
     */
    public function testDefault()
    {
        $this->assertEquals($this->di, Sample::getDefault());

        Sample::reset();
        $this->assertNull(Sample::getDefault());

        Sample::setDefault($this->di);
        $this->assertEquals($this->di, Sample::getDefault());
    }

    /**
     * 测试通过回调设置服务
     *
     * @throws \Di\Exception
     */
    public function testCallbackService()
    {
        $this->di->set('std', function () {
            return new \stdClass();
        });

        $this->assertSame(new \stdClass(), $this->di->get('std'));

        $this->assertFalse($this->di->get('std') === $this->di->get('std'));

        $this->di->set('std', function () {
            return new \stdClass();
        }, true);

        $this->assertTrue($this->di->get('std') === $this->di->get('std'));
    }

    /**
     * 测试通过类名设置服务
     *
     * @throws \Di\Exception
     */
    public function testClassNameService()
    {
        $this->di->set('di', 'Di\Sample');

        $this->assertSame($this->di, $this->di->get('di'));

        $this->assertFalse($this->di->get('di') === $this->di->get('di'));

        $this->di->set('di', 'Di\Sample', true);

        $this->assertTrue($this->di->get('di') === $this->di->get('di'));
    }
}
