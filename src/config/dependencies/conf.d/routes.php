<?php

declare(strict_types=1);

namespace Phpolar\MyApp;

use PhpCommonEnums\HttpMethod\Enumeration\HttpMethodEnum as HttpMethod;
use PhpCommonEnums\MimeType\Enumeration\MimeTypeEnum as MimeType;
use Phpolar\Example\DeletePerson;
use Phpolar\Example\GetPeople;
use Phpolar\Example\GetPersonForm;
use Phpolar\Example\SubmitPersonForm;
use Phpolar\Phpolar\Http\Representations;
use Phpolar\Phpolar\Http\Server;
use Phpolar\Phpolar\Http\ServerInterface;
use Phpolar\Phpolar\Http\Target;

return [
    ServerInterface::class => new Server(
        interface: [
            new Target(
                location: "/",
                method: HttpMethod::Get,
                representations: new Representations([
                    MimeType::TextHtml,
                ]),
                requestProcessor: new GetPeople(),
            ),
            new Target(
                location: "/person/form",
                method: HttpMethod::Get,
                representations: new Representations([
                    MimeType::TextHtml,
                ]),
                requestProcessor: new GetPersonForm(),
            ),
            new Target(
                location: "/person/add",
                method: HttpMethod::Post,
                representations: new Representations([
                    MimeType::TextHtml,
                ]),
                requestProcessor: new SubmitPersonForm(),
            ),
            new Target(
                location: "/person/delete/{id}",
                method: HttpMethod::Post,
                representations: new Representations([
                    MimeType::TextHtml,
                ]),
                requestProcessor: new DeletePerson(),
            ),
        ]
    ),
];
