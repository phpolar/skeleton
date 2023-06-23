<?php

declare(strict_types=1);

namespace Phpolar\Example;

use Phpolar\Model\Model;
use Phpolar\Phpolar\Http\RoutableInterface;
use Phpolar\Phpolar\Storage\AbstractStorage;
use Phpolar\Phpolar\Storage\Item;
use Phpolar\Phpolar\Storage\ItemKey;
use Phpolar\PurePhp\HtmlSafeContext;
use Phpolar\PurePhp\TemplateEngine;
use Psr\Container\ContainerInterface;

final class SubmitPersonForm implements RoutableInterface
{
    public function process(ContainerInterface $container, #[Model] ?Person $person = null): string
    {
        $templateEngine = $container->get(TemplateEngine::class);
        if ($person->isValid() === true) {
            $person->create();
            $this->savePerson($person, $container);
            return $templateEngine->apply("example/templates/person-saved.phtml");
        }
        $person->isPosted();
        return $templateEngine->apply(
            "example/templates/add-person-form.phtml",
            new HtmlSafeContext($person),
        );
    }

    private function savePerson(Person $person, ContainerInterface $container): void
    {
        $storage = $container->get(AbstractStorage::class);
        $key = new ItemKey($person->id);
        $item = new Item($person);
        $storage->storeByKey($key, $item);
        $storage->commit();
    }
}
