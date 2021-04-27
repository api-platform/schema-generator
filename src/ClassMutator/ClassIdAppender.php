<?php

namespace ApiPlatform\SchemaGenerator\ClassMutator;

use ApiPlatform\SchemaGenerator\Model\Class_;
use ApiPlatform\SchemaGenerator\PropertyGenerator\IdPropertyGenerator;

final class ClassIdAppender implements ClassMutatorInterface
{
    private array $config;

    public function __construct(array $config)
    {
        $this->config = $config;
    }

    public function __invoke(Class_ $class): Class_
    {
        if (
            $class->isEnum()
            || $class->isEmbeddable()
            || ($class->hasParent() && 'parent' === $this->config['id']['onClass'])
            || ($class->hasChild() && 'child' === $this->config['id']['onClass'])
        ) {
            return $class;
        }

        return $class->addProperty((new IdPropertyGenerator)($this->config['id']['generationStrategy'], $this->config['id']['writable'] ?? false));
    }
}
