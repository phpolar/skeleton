<?php

declare(strict_types=1);

use Phpolar\PropertyInjector\PropertyInjector;
use Phpolar\PropertyInjectorContract\PropertyInjectorInterface;
use Psr\Container\ContainerInterface;

return [
    PropertyInjectorInterface::class => static fn(ContainerInterface $container) => new PropertyInjector($container),
];
