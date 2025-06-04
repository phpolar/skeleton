<?php

declare(strict_types=1);

namespace Phpolar\Example;

use Phpolar\Routable\RoutableInterface;
use Phpolar\PropertyInjector\Inject;
use Phpolar\PurePhp\TemplateEngine;
use Phpolar\Storage\StorageContext;

final class DeletePerson implements RoutableInterface
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
        return $result instanceof Person ? $this->templateEngine->apply("example/templates/person-deleted.phtml") : $result;
    }
}
