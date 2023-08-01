<?php

declare(strict_types=1);

namespace Phpolar\MyApp;

use Phpolar\Example\DeletePerson;
use Phpolar\Example\GetPeople;
use Phpolar\Example\GetPersonForm;
use Phpolar\Example\SubmitPersonForm;
use Phpolar\Phpolar\Http\RouteMap;

$routes = new RouteMap();
$routes->add("GET", "/", new GetPeople());
$routes->add("GET", "/person/form", new GetPersonForm());
$routes->add("POST", "/person/add", new SubmitPersonForm());
$routes->add("POST", "/person/delete/{id}", new DeletePerson());

return [RouteMap::class => $routes];
