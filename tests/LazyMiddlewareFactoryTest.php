<?php

namespace BlackhawkElectronics\Middleware;

use BlackhawkElectronics\Middleware\Fixture\Middleware;
use BlackhawkElectronics\Middleware\Fixture\TempContainer;
use PHPUnit\Framework\TestCase;
use Psr\Http\Server\MiddlewareInterface;

class LazyMiddlewareFactoryTest extends TestCase
{
    private LazyMiddlewareFactory $factory;

    protected function setUp(): void
    {
        $this->factory = new LazyMiddlewareFactory(new TempContainer());
    }

    public function testCreatesProxyMiddleware(): void
    {
        $middleware = $this->factory->defer(Middleware::class);

        $this->assertInstanceOf(MiddlewareInterface::class, $middleware);
    }
}
