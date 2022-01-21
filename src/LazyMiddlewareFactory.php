<?php

namespace BlackhawkElectronics\Middleware;

use Psr\Container\ContainerInterface;

class LazyMiddlewareFactory
{
    private ContainerInterface $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * Add a lazy middleware instance
     *
     * @param string $middleware
     * @return LazyMiddleware
     */
    public function defer(string $middleware): LazyMiddleware
    {
        return new LazyMiddleware($this->container, $middleware);
    }
}
