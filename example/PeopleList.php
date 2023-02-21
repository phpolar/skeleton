<?php

declare(strict_types=1);

namespace Phpolar\Example;

final class PeopleList
{
    public array $people;

    public function __construct(Person ...$people)
    {
        $this->people = $people;
    }
}
