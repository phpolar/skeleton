<?php

declare(strict_types=1);

namespace Phpolar\Example;

use Phpolar\HttpRequestProcessor\RequestProcessorInterface;
use Phpolar\Model\Model;
use Phpolar\PropertyInjector\Inject;
use Phpolar\PurePhp\HtmlSafeContext;
use Phpolar\PurePhp\TemplateEngine;

final class GetPersonForm implements RequestProcessorInterface
{
    #[Inject]
    public TemplateEngine $templateEngine;

    public function process(#[Model] ?Person $person = null): string
    {
        return (string) $this->templateEngine->apply(
            "example/templates/add-person-form.phtml",
            new HtmlSafeContext($person ?? new Person()),
        );
    }
}
