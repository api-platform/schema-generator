<?php

namespace ApiPlatform\SchemaGenerator\ClassMutator;

use ApiPlatform\SchemaGenerator\Model\Class_;
use ApiPlatform\SchemaGenerator\Model\Interface_;

final class ClassInterfaceMutator implements ClassMutatorInterface
{
    private string $desiredNamespace;

    public function __construct(string $desiredNamespace)
    {
        $this->desiredNamespace = $desiredNamespace;
    }

    public function __invoke(Class_ $class): Class_
    {
        return $class->withInterface(new Interface_(sprintf("%sInterface", $class->name()), $this->desiredNamespace));
    }
}
