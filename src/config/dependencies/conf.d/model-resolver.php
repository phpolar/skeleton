<?php

declare(strict_types=1);

namespace Phpolar\MyApp;

use Phpolar\Model\ModelResolver;
use Phpolar\ModelResolver\ModelResolverInterface;

return [
    ModelResolverInterface::class => new ModelResolver($_REQUEST),
];
