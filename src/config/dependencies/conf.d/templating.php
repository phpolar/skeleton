<?php

declare(strict_types=1);

namespace Phpolar\MyApp;

use Phpolar\PhpTemplating\Binder;
use Phpolar\PhpTemplating\Dispatcher;
use Phpolar\PhpTemplating\StreamContentStrategy;
use Phpolar\PhpTemplating\TemplateEngine;

return [
    TemplateEngine::class => static fn () => new TemplateEngine(
        new StreamContentStrategy(),
        new Binder(),
        new Dispatcher(),
    ),
];
