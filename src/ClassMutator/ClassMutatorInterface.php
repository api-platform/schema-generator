<?php

namespace ApiPlatform\SchemaGenerator\ClassMutator;

use ApiPlatform\SchemaGenerator\Model\Class_;

interface ClassMutatorInterface
{
    public function __invoke(Class_ $class): Class_;
}

