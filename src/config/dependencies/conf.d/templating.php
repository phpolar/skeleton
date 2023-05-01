<?php

declare(strict_types=1);

namespace Phpolar\MyApp;

use Phpolar\PurePhp\Binder;
use Phpolar\PurePhp\Dispatcher;
use Phpolar\PurePhp\StreamContentStrategy;
use Phpolar\PurePhp\TemplateEngine;



return [
    TemplateEngine::class => static fn () => new TemplateEngine(
        new StreamContentStrategy(),
        new Binder(),
        new Dispatcher(),
    ),
];
