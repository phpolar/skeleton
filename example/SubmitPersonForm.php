<?php

declare(strict_types=1);

namespace Phpolar\Example;

use Phpolar\Phpolar\Routing\AbstractRouteDelegate;
use Phpolar\Phpolar\Storage\AbstractStorage;
use Phpolar\Phpolar\Storage\Item;
use Phpolar\Phpolar\Storage\ItemKey;
use Phpolar\PhpTemplating\HtmlSafeContext;
use Phpolar\PhpTemplating\TemplateEngine;
use Psr\Container\ContainerInterface;

final class SubmitPersonForm extends AbstractRouteDelegate
{
    public function __construct(
        private Person $person,
    ) {
    }

    public function handle(ContainerInterface $container): string
    {
        $templateEngine = $container->get(TemplateEngine::class);
        if ($this->person->isValid() === true) {
            $this->savePerson(uniqid(), $this->person, $container);
            return $templateEngine->apply("person-saved");
        }
        return $templateEngine->apply(
            "example/templates/add-person-form.phtml",
            new HtmlSafeContext($this->person),
        );
    }

    private function savePerson(string $key, Person $person, ContainerInterface $container): void
    {
        $storage = $container->get(AbstractStorage::class);
        $key = new ItemKey(uniqid());
        $storage->load();
        $storage->storeByKey($key, new Item($person));
        $storage->commit();
    }
}
