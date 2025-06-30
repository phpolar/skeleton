<?php

declare(strict_types=1);

namespace Phpolar\Example;

use Phpolar\HttpRequestProcessor\RequestProcessorInterface;
use Phpolar\Model\Model;
use Phpolar\PropertyInjector\Inject;
use Phpolar\PurePhp\HtmlSafeContext;
use Phpolar\PurePhp\TemplateEngine;
use Phpolar\Storage\StorageContext;

final class SubmitPersonForm implements RequestProcessorInterface
{
    #[Inject]
    public TemplateEngine $templateEngine;

    #[Inject("PEOPLE_STORAGE")]
    public StorageContext $storage;

    public function process(#[Model] Person $person = new Person()): string
    {
        if ($person->isValid() === true) {
            $person->create();
            $this->storage->save($person->id, $person);
            return (string) $this->templateEngine->apply("example/templates/person-saved.phtml");
        }
        $person->isPosted();
        return (string) $this->templateEngine->apply(
            "example/templates/add-person-form.phtml",
            new HtmlSafeContext($person),
        );
    }
}
