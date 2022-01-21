<?php

namespace BlackhawkElectronics\Middleware;

use InvalidArgumentException;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class LazyMiddleware implements MiddlewareInterface
{
    private ContainerInterface $container;
    private string $middleware;

    public function __construct(ContainerInterface $container, string $middleware)
    {
        if ($container->has($middleware) === false) {
            throw new InvalidArgumentException(sprintf('Container is missing middleware "%s"', $middleware));
        }

        $this->container = $container;
        $this->middleware = $middleware;
    }

    /**
     * @param ServerRequestInterface $request
     * @param RequestHandlerInterface $handler
     * @return ResponseInterface
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        return $this->resolve()->process($request, $handler);
    }

    /**
     * @return MiddlewareInterface
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    private function resolve(): MiddlewareInterface
    {
        return $this->container->get($this->middleware);
    }
}
