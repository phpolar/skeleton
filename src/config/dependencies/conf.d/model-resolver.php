<?php

declare(strict_types=1);

namespace Phpolar\MyApp;

use Phpolar\Model\ParsedBodyResolver;
use Phpolar\ModelResolver\ModelResolverInterface;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface;

return [
    ModelResolverInterface::class => static function (ContainerInterface $container) {
        return new ParsedBodyResolver(
            $container->get(ServerRequestInterface::class)
                ->getParsedBody()
        );
    }
];
