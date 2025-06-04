<?php

declare(strict_types=1);

namespace Phpolar\Example;

use Phpolar\Model\Model;
use Phpolar\Routable\RoutableInterface;
use Phpolar\PropertyInjector\Inject;
use Phpolar\PurePhp\HtmlSafeContext;
use Phpolar\PurePhp\TemplateEngine;
use Phpolar\Storage\StorageContext;

final class SubmitPersonForm implements RoutableInterface
{
    #[Inject]
    public TemplateEngine $templateEngine;

    #[Inject("PEOPLE_STORAGE")]
    public StorageContext $storage;

    public function process(#[Model] ?Person $person = null): string
    {
        if ($person->isValid() === true) {
            $person->create();
            $this->storage->save($person->id, $person);
            return $this->templateEngine->apply("example/templates/person-saved.phtml");
        }
        $person->isPosted();
        return $this->templateEngine->apply(
            "example/templates/add-person-form.phtml",
            new HtmlSafeContext($person),
        );
    }
}
