<?php

declare(strict_types=1);

namespace Phpolar\MyApp;

use Phpolar\CsvFileStorage\CsvFileStorage;
use Phpolar\Phpolar\Storage\AbstractStorage;

/**
 * This contains the services/dependencies required
 * by the PHPolar Microframework.
 */
return [
    "csv_storage" => "data/people.csv",
    AbstractStorage::class => static fn (
        $container
    ) => new CsvFileStorage($container["csv_storage"]),
];
