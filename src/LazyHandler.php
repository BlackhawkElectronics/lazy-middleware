<?php

namespace BlackhawkElectronics\Middleware;

use InvalidArgumentException;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class LazyHandler implements RequestHandlerInterface
{
    private ContainerInterface $container;
    private string $handler;

    public function __construct(ContainerInterface $container, string $handler)
    {
        if ($container->has($handler) === false) {
            throw new InvalidArgumentException(sprintf('Container is missing handler "%s"', $handler));
        }

        $this->container = $container;
        $this->handler = $handler;
    }

    /**
     * @param ServerRequestInterface $request
     * @return ResponseInterface
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        return $this->resolve()->handle($request);
    }

    /**
     * @return RequestHandlerInterface
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    private function resolve(): RequestHandlerInterface
    {
        return $this->container->get($this->handler);
    }
}
