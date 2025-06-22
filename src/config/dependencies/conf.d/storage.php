<?php

declare(strict_types=1);

namespace Phpolar\MyApp;

use Phpolar\CsvFileStorage\CsvFileStorage;
use Phpolar\Example\Person;
use Psr\Container\ContainerInterface;

const CSV_STORAGE = "data/example.csv";
/**
 * This contains the services/dependencies required
 * by the PHPolar Microframework.
 */
return [
    "csv_file" => join(DIRECTORY_SEPARATOR, [getcwd(), CSV_STORAGE]),
    "PEOPLE_STORAGE" => static fn(ContainerInterface $container) => new CsvFileStorage($container->get("csv_file"), Person::class),
];
