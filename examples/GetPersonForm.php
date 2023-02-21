<?php

declare(strict_types=1);

namespace Phpolar\Example;

use Phpolar\Phpolar\Routing\AbstractRouteDelegate;
use Phpolar\PhpTemplating\HtmlSafeContext;
use Phpolar\PhpTemplating\TemplateEngine;
use Psr\Container\ContainerInterface;

final class GetPersonForm extends AbstractRouteDelegate
{
    public function __construct(
        private Person $person,
        protected bool $isPosted = false,
    ) {
    }

    public function handle(ContainerInterface $container): string
    {
        if ($this->isPosted) {
            $this->person->isPosted();
        }
        $templateEngine = $container->get(TemplateEngine::class);
        return $templateEngine->apply(
            "examples/templates/add-person-form.phtml",
            new HtmlSafeContext($this->person),
        );
    }
}
