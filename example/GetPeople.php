<?php

declare(strict_types=1);

namespace Phpolar\Example;

use Phpolar\Phpolar\Storage\AbstractStorage;
use Phpolar\PropertyInjector\Inject;
use Phpolar\Routable\RoutableInterface;
use Phpolar\PurePhp\HtmlSafeContext;
use Phpolar\PurePhp\TemplateEngine;

final class GetPeople implements RoutableInterface
{
    #[Inject]
    public TemplateEngine $templateEngine;

    #[Inject("PEOPLE_STORAGE")]
    public AbstractStorage $storage;

    public function process(): string
    {
        /**
         * @var Person[] $people
         */
        $people = array_map(static fn (array|object $data) => new Person($data), $this->storage->getAll());
        $peopleList = new PeopleList($people);
        return $this->templateEngine->apply(
            "example/templates/people-list.phtml",
            new HtmlSafeContext($peopleList),
        );
    }
}
