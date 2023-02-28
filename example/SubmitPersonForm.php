<?php

declare(strict_types=1);

namespace Phpolar\Example;

use Phpolar\Phpolar\Routing\AbstractContentDelegate;
use Phpolar\Phpolar\Storage\AbstractStorage;
use Phpolar\Phpolar\Storage\Item;
use Phpolar\Phpolar\Storage\ItemKey;
use Phpolar\PurePhp\HtmlSafeContext;
use Phpolar\PurePhp\TemplateEngine;
use Psr\Container\ContainerInterface;

final class SubmitPersonForm extends AbstractContentDelegate
{
    public function __construct(
        private Person $person,
    ) {
    }

    public function getResponseContent(ContainerInterface $container): string
    {
        $templateEngine = $container->get(TemplateEngine::class);
        if ($this->person->isValid() === true) {
            $this->savePerson(uniqid(), $this->person, $container);
            return $templateEngine->apply("example/templates/person-saved.phtml");
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
