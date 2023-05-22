<?php

declare(strict_types=1);

namespace Phpolar\MyApp;

use Phpolar\CsvFileStorage\CsvFileStorage;
use Phpolar\Example\Person;
use Phpolar\Phpolar\Storage\AbstractStorage;

const CSV_STORAGE = "data/example.csv";
/**
 * This contains the services/dependencies required
 * by the PHPolar Microframework.
 */
return [
    AbstractStorage::class => new CsvFileStorage(CSV_STORAGE),
    "PEOPLE_STORAGE" => new CsvFileStorage(CSV_STORAGE, Person::class),
];
