<?php

namespace BlackhawkElectronics\Middleware;

use BlackhawkElectronics\Middleware\Fixture\TempContainer;
use InvalidArgumentException;
use BlackhawkElectronics\Middleware\Fixture\Handler;
use Nyholm\Psr7\ServerRequest;
use PHPUnit\Framework\TestCase;

class LazyHandlerTest extends TestCase
{
    private TempContainer $container;

    protected function setUp(): void
    {
        $this->container = new TempContainer();
    }

    public function testDefersToHandlerImplementation(): void
    {
        $handler = new LazyHandler($this->container, Handler::class);

        $request = new ServerRequest('GET', 'https://example.com/');

        $response = $handler->handle($request);

        $this->assertEquals(400, $response->getStatusCode());
    }

    public function testFailsIfContainerDoesNotHaveHandler(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('invalid');

        new LazyHandler($this->container, 'invalid');
    }
}
