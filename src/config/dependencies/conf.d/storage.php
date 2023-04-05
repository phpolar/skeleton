<?php

declare(strict_types=1);

namespace Phpolar\MyApp;

use Phpolar\CsvFileStorage\CsvFileStorage;
use Phpolar\Example\Person;
use Phpolar\Phpolar\Storage\AbstractStorage;
use Psr\Container\ContainerInterface;

/**
 * This contains the services/dependencies required
 * by the PHPolar Microframework.
 */
return [
    "csv_storage" => "data/example.csv",
    AbstractStorage::class => static fn (
        ContainerInterface $container
    ) => new CsvFileStorage($container->get("csv_storage")),
    "PEOPLE_STORAGE" => static fn (ContainerInterface $container) => new CsvFileStorage($container->get("csv_storage"), Person::class),
];
