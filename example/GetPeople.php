<?php

declare(strict_types=1);

namespace Phpolar\Example;

use Phpolar\Phpolar\Routing\AbstractContentDelegate;
use Phpolar\Phpolar\Storage\AbstractStorage;
use Phpolar\PurePhp\HtmlSafeContext;
use Phpolar\PurePhp\TemplateEngine;
use Psr\Container\ContainerInterface;

final class GetPeople extends AbstractContentDelegate
{
    public function __construct()
    {
    }

    public function getResponseContent(ContainerInterface $container): string
    {
        $storage = $container->get(AbstractStorage::class);
        $templateEngine = $container->get(TemplateEngine::class);
        $storage->load();
        /**
         * @var Person[] $people
         */
        $people = array_map(static fn (array|object $data) => new Person($data), $storage->getAll());
        $peopleList = new PeopleList(...$people);
        return $templateEngine->apply(
            "example/templates/people-list.phtml",
            new HtmlSafeContext($peopleList),
        );
    }
}
