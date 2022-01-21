<?php

namespace BlackhawkElectronics\Middleware;

use Psr\Container\ContainerInterface;

class LazyHandlerFactory
{
    private ContainerInterface $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * Add a lazy middleware instance
     *
     * @param string $handler
     * @return LazyHandler
     */
    public function defer(string $handler): LazyHandler
    {
        return new LazyHandler($this->container, $handler);
    }
}
