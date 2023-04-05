<?php

declare(strict_types=1);

namespace Phpolar\Example;

use Phpolar\Phpolar\Model\Model;
use Phpolar\Phpolar\Routing\AbstractContentDelegate;
use Phpolar\PurePhp\HtmlSafeContext;
use Phpolar\PurePhp\TemplateEngine;
use Psr\Container\ContainerInterface;

final class GetPersonForm extends AbstractContentDelegate
{
    public function getResponseContent(ContainerInterface $container, #[Model] ?Person $person = null): string
    {
        $templateEngine = $container->get(TemplateEngine::class);
        $htmlSafe = new HtmlSafeContext($person);
        return $templateEngine->apply(
            "example/templates/add-person-form.phtml",
            $htmlSafe,
        );
    }
}
