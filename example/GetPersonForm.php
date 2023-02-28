<?php

declare(strict_types=1);

namespace Phpolar\Example;

use Phpolar\Phpolar\Routing\AbstractContentDelegate;
use Phpolar\PurePhp\HtmlSafeContext;
use Phpolar\PurePhp\TemplateEngine;
use Psr\Container\ContainerInterface;

final class GetPersonForm extends AbstractContentDelegate
{
    public function __construct(
        private Person $person,
        protected bool $isPosted = false,
    ) {
    }

    public function getResponseContent(ContainerInterface $container): string
    {
        if ($this->isPosted) {
            $this->person->isPosted();
        }
        $templateEngine = $container->get(TemplateEngine::class);
        $htmlSafe = new HtmlSafeContext($this->person);
        return $templateEngine->apply(
            "example/templates/add-person-form.phtml",
            $htmlSafe,
        );
    }
}
