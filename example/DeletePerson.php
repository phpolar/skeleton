<?php

declare(strict_types=1);

namespace Phpolar\Example;

use Phpolar\Routable\RoutableInterface;
use Phpolar\Phpolar\Storage\AbstractStorage;
use Phpolar\Phpolar\Storage\ItemKey;
use Phpolar\Phpolar\Storage\KeyNotFound;
use Phpolar\PropertyInjector\Inject;
use Phpolar\PurePhp\TemplateEngine;

final class DeletePerson implements RoutableInterface
{
    #[Inject]
    public TemplateEngine $templateEngine;

    #[Inject("PEOPLE_STORAGE")]
    public AbstractStorage $storage;

    public function process(string $id = ""): string
    {
        $key = $this->deletePerson($id);
        if ($key instanceof KeyNotFound) {
            return $this->templateEngine->apply("404");
        }
        return $this->templateEngine->apply("example/templates/person-deleted.phtml");
    }

    private function deletePerson(string $personId): ItemKey|KeyNotFound
    {
        $key = new ItemKey($personId);
        $this->storage->removeByKey($key);
        $this->storage->commit();
        return $key;
    }
}
