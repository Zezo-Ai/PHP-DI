<?php

declare(strict_types=1);

namespace DI\Test\UnitTest\Proxy;

use DI\Proxy\NativeProxyFactory;
use DI\Test\UnitTest\Proxy\Fixtures\ClassToProxy;
use PHPUnit\Framework\TestCase;

/**
 * @covers \DI\Proxy\NativeProxyFactory
 * @requires PHP 8.4
 */
#[\PHPUnit\Framework\Attributes\CoversClass(\DI\Proxy\NativeProxyFactory::class)]
class NativeProxyFactoryTest extends TestCase
{
    /**
     * @test
     */
    #[\PHPUnit\Framework\Attributes\Test]
    public function should_create_native_lazy_proxies()
    {
        $factory = new NativeProxyFactory;

        $instance = new ClassToProxy();
        $initialized = false;

        $initializer = function () use ($instance, &$initialized) {
            $initialized = true;
            return $instance;
        };

        /** @var ClassToProxy $proxy */
        $proxy = $factory->createProxy(ClassToProxy::class, $initializer);

        $this->assertFalse($initialized);
        $this->assertInstanceOf(ClassToProxy::class, $proxy);

        $proxy->foo();

        $this->assertTrue($initialized);
    }
}
