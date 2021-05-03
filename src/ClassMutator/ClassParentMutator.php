<?php

declare(strict_types=1);

namespace ApiPlatform\SchemaGenerator\ClassMutator;

use ApiPlatform\SchemaGenerator\Model\Class_;
use ApiPlatform\SchemaGenerator\PhpTypeConverterInterface;
use Psr\Log\LoggerInterface;

final class ClassParentMutator implements ClassMutatorInterface
{
    private PhpTypeConverterInterface $phpTypeConverter;
    private LoggerInterface $logger;
    private array $config;

    public function __construct(array $config, PhpTypeConverterInterface $phpTypeConverter, LoggerInterface $logger)
    {
        $this->phpTypeConverter = $phpTypeConverter;
        $this->logger = $logger;
        $this->config = $config;
    }

    public function __invoke(Class_ $class): Class_
    {
        $typeConfig = $this->config['types'][$class->name()];
        $class->withParent($typeConfig['parent'] ?? null);

        if (null === $class->parent() && $subclassOf = $class->getSubClassOf()) {
            if (\count($subclassOf) > 1) {
                $this->logger->warning(sprintf('The type "%s" has several supertypes. Using the first one.', $class->resourceUri()));
            }

            $class->setParent($this->phpTypeConverter->escapeIdentifier($subclassOf[0]->localName()));
        }

        if ($class->hasParent() && isset($config['types'][$class->parent()]['namespaces']['class'])) {
            $parentNamespace = $config['types'][$class->parent()]['namespaces']['class'];

            if ($class->isInNamespace($parentNamespace)) {
                $class->addUse($parentNamespace.'\\'.$class->parent());
            }
        }

        return $class;
    }
}
