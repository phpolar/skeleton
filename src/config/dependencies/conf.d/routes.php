<?php

declare(strict_types=1);

namespace Phpolar\MyApp;

use Phpolar\Example\DeletePerson;
use Phpolar\Example\GetPeople;
use Phpolar\Example\GetPersonForm;
use Phpolar\Example\SubmitPersonForm;
use Phpolar\Phpolar\Http\RequestMethods;
use Phpolar\Phpolar\Http\RouteMap;
use Phpolar\PropertyInjector\PropertyInjector;
use Psr\Container\ContainerInterface;


return [
    RouteMap::class => static function (ContainerInterface $container): RouteMap {
        $routes = new RouteMap(new PropertyInjector($container));
        $routes->add(RequestMethods::GET, "/", new GetPeople());
        $routes->add(RequestMethods::GET, "/person/form", new GetPersonForm());
        $routes->add(RequestMethods::POST, "/person/add", new SubmitPersonForm());
        $routes->add(RequestMethods::POST, "/person/delete/{id}", new DeletePerson());
        return $routes;
    },
];
