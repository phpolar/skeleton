<?php

declare(strict_types=1);

use Pimple\Psr11\Container;
use Psr\Container\ContainerInterface;

return [ContainerInterface::class => static fn (ArrayAccess $config) => new Container($config)];
