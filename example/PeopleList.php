<?php

declare(strict_types=1);

namespace Phpolar\Example;

final class PeopleList
{
    /**
     * @param Person[] $people
     */
    public function __construct(public array $people)
    {
    }
}
