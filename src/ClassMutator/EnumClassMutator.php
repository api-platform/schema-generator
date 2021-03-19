<?php

namespace ApiPlatform\SchemaGenerator\ClassMutator;

use ApiPlatform\SchemaGenerator\Model\Class_;
use ApiPlatform\SchemaGenerator\Model\Constant;
use ApiPlatform\SchemaGenerator\PhpTypeConverterInterface;
use EasyRdf\Graph;
use MyCLabs\Enum\Enum;

final class EnumClassMutator implements ClassMutatorInterface
{
    private PhpTypeConverterInterface $phpTypeConverter;

    /**
     * @var Graph[]
     */
    private array $graphs;
    private string $desiredNamespace;

    public function __construct(PhpTypeConverterInterface $phpTypeConverter, array $graphs, string $desiredNamespace)
    {
        $this->phpTypeConverter = $phpTypeConverter;
        $this->graphs = $graphs;
        $this->desiredNamespace = $desiredNamespace;
    }

    public function __invoke(Class_ $class): Class_
    {
        $class = $class->withNamespace($this->desiredNamespace)
            ->withParent('Enum')
            ->addUse(Enum::class);

        foreach ($this->graphs as $graph) {
            foreach ($graph->allOfType($class->resourceUri()) as $instance) {
                $class->addConstant($instance->localName(), new Constant(
                    $this->phpTypeConverter->escapeIdentifier(strtoupper(substr(preg_replace('/([A-Z])/', '_$1', $instance->localName()), 1))),
                    $instance
                ));
            }
        }

        return $class;
    }
}
