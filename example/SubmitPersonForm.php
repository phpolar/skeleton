<?php

declare(strict_types=1);

namespace Phpolar\Example;

use Phpolar\Model\Model;
use Phpolar\Routable\RoutableInterface;
use Phpolar\Phpolar\Storage\AbstractStorage;
use Phpolar\Phpolar\Storage\Item;
use Phpolar\Phpolar\Storage\ItemKey;
use Phpolar\PropertyInjector\Inject;
use Phpolar\PurePhp\HtmlSafeContext;
use Phpolar\PurePhp\TemplateEngine;

final class SubmitPersonForm implements RoutableInterface
{
    #[Inject]
    public TemplateEngine $templateEngine;

    #[Inject]
    public AbstractStorage $storage;

    public function process(#[Model] ?Person $person = null): string
    {
        if ($person->isValid() === true) {
            $person->create();
            $this->savePerson($person);
            return $this->templateEngine->apply("example/templates/person-saved.phtml");
        }
        $person->isPosted();
        return $this->templateEngine->apply(
            "example/templates/add-person-form.phtml",
            new HtmlSafeContext($person),
        );
    }

    private function savePerson(Person $person): void
    {
        $key = new ItemKey($person->id);
        $item = new Item($person);
        $this->storage->storeByKey($key, $item);
        $this->storage->commit();
    }
}
