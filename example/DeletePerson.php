<?php

declare(strict_types=1);

namespace Phpolar\Example;

use Phpolar\Routable\RoutableInterface;
use Phpolar\Phpolar\Storage\AbstractStorage;
use Phpolar\Phpolar\Storage\ItemKey;
use Phpolar\Phpolar\Storage\KeyNotFound;
use Phpolar\PurePhp\TemplateEngine;
use Psr\Container\ContainerInterface;

final class DeletePerson implements RoutableInterface
{
    public function process(ContainerInterface $container, string $id = ""): string
    {
        /**
         * @var TemplateEngine $templateEngine
         */
        $templateEngine = $container->get(TemplateEngine::class);
        $key = $this->deletePerson($id, $container);
        if ($key instanceof KeyNotFound) {
            return $templateEngine->apply("404");
        }
        return $templateEngine->apply("example/templates/person-deleted.phtml");
    }

    private function deletePerson(string $personId, ContainerInterface $container): ItemKey|KeyNotFound
    {
        /**
         * @var AbstractStorage $storage
         */
        $storage = $container->get("PEOPLE_STORAGE");
        $key = new ItemKey($personId);
        $storage->removeByKey($key);
        $storage->commit();
        return $key;
    }
}
