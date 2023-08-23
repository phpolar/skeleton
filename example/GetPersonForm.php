<?php

declare(strict_types=1);

namespace Phpolar\Example;

use Phpolar\Model\Model;
use Phpolar\PropertyInjector\Inject;
use Phpolar\Routable\RoutableInterface;
use Phpolar\PurePhp\HtmlSafeContext;
use Phpolar\PurePhp\TemplateEngine;

final class GetPersonForm implements RoutableInterface
{
    #[Inject]
    public TemplateEngine $templateEngine;

    public function process(#[Model] ?Person $person = null): string
    {
        $htmlSafe = new HtmlSafeContext($person);
        return $this->templateEngine->apply(
            "example/templates/add-person-form.phtml",
            $htmlSafe,
        );
    }
}
