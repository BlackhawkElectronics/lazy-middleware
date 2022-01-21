<?php

namespace BlackhawkElectronics\Middleware\Fixture;

use Psr\Container\ContainerInterface;

class TempContainer implements ContainerInterface
{
    /**
     * @param string $id
     * @return bool
     */
    public function has($id): bool
    {
        return class_exists($id);
    }

    /**
     * @param string $id
     * @return mixed
     */
    public function get($id)
    {
        return new $id();
    }
}