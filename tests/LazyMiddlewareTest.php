<?php

namespace BlackhawkElectronics\Middleware;

use BlackhawkElectronics\Middleware\Fixture\TempContainer;
use InvalidArgumentException;
use BlackhawkElectronics\Middleware\Fixture\Handler;
use BlackhawkElectronics\Middleware\Fixture\Middleware;
use Nyholm\Psr7\ServerRequest;
use PHPUnit\Framework\TestCase;

class LazyMiddlewareTest extends TestCase
{
    private TempContainer $container;

    protected function setUp(): void
    {
        $this->container = new TempContainer();
    }

    public function testDefersToMiddlewareImplemention(): void
    {
        $middleware = new LazyMiddleware($this->container, Middleware::class);

        $handler = new Handler();
        $request = new ServerRequest('GET', 'https://example.com/');

        $response = $middleware->process($request, $handler);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(Middleware::class, (string) $response->getBody());
    }

    public function testFailsIfContainerDoesNotHaveMiddleware(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('invalid');

        new LazyMiddleware($this->container, 'invalid');
    }
}
