<?php

declare(strict_types=1);

namespace Phpolar\Example;

use Phpolar\PropertyInjector\Inject;
use Phpolar\Routable\RoutableInterface;
use Phpolar\PurePhp\HtmlSafeContext;
use Phpolar\PurePhp\TemplateEngine;
use Phpolar\Storage\StorageContext;

final class GetPeople implements RoutableInterface
{
    #[Inject]
    public TemplateEngine $templateEngine;

    #[Inject("PEOPLE_STORAGE")]
    public StorageContext $storage;

    public function process(): string
    {
        /**
         * @var Person[] $people
         */
        $people = array_map(static fn(array|object $data) => new Person($data), $this->storage->findAll());
        $peopleList = new PeopleList($people);
        return $this->templateEngine->apply(
            "example/templates/people-list.phtml",
            new HtmlSafeContext($peopleList),
        );
    }
}
