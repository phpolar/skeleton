<?php

declare(strict_types=1);

namespace Phpolar\Example;

use Phpolar\HttpRequestProcessor\RequestProcessorInterface;
use Phpolar\PropertyInjector\Inject;
use Phpolar\PurePhp\TemplateEngine;
use Phpolar\Storage\StorageContext;

final class DeletePerson implements RequestProcessorInterface
{
    #[Inject]
    public TemplateEngine $templateEngine;

    #[Inject("PEOPLE_STORAGE")]
    public StorageContext $storage;

    public function process(string $id = ""): string
    {
        $result = $this->storage
            ->remove($id)
            ->orElse(static fn() => $this->templateEngine->apply("404"))
            ->tryUnwrap();
        if ($result instanceof Person) {
            return (string) $this->templateEngine->apply("example/templates/person-deleted.phtml");
        }
        return $result;
    }
}
