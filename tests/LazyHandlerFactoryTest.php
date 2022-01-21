<?php

namespace BlackhawkElectronics\Middleware;

use BlackhawkElectronics\Middleware\Fixture\Handler;
use BlackhawkElectronics\Middleware\Fixture\TempContainer;
use PHPUnit\Framework\TestCase;
use Psr\Http\Server\RequestHandlerInterface;

class LazyHandlerFactoryTest extends TestCase
{
    private LazyHandlerFactory $factory;

    protected function setUp(): void
    {
        $this->factory = new LazyHandlerFactory(new TempContainer());
    }

    public function testCreatesProxyHandler(): void
    {
        $handler = $this->factory->defer(Handler::class);

        $this->assertInstanceOf(RequestHandlerInterface::class, $handler);
    }
}
