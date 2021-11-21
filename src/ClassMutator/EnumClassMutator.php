<?php

/*
 * This file is part of the API Platform project.
 *
 * (c) Kévin Dunglas <dunglas@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace ApiPlatform\SchemaGenerator\ClassMutator;

use ApiPlatform\SchemaGenerator\Model\Class_;
use ApiPlatform\SchemaGenerator\Model\Constant;
use ApiPlatform\SchemaGenerator\Model\Use_;
use ApiPlatform\SchemaGenerator\PhpTypeConverterInterface;
use EasyRdf\Graph as RdfGraph;
use MyCLabs\Enum\Enum;

final class EnumClassMutator implements ClassMutatorInterface
{
    private PhpTypeConverterInterface $phpTypeConverter;

    /**
     * @var RdfGraph[]
     */
    private array $graphs;
    private string $desiredNamespace;

    /**
     * @param RdfGraph[] $graphs
     */
    public function __construct(PhpTypeConverterInterface $phpTypeConverter, array $graphs, string $desiredNamespace)
    {
        $this->phpTypeConverter = $phpTypeConverter;
        $this->graphs = $graphs;
        $this->desiredNamespace = $desiredNamespace;
    }

    public function __invoke(Class_ $class): Class_
    {
        $class->namespace = $this->desiredNamespace;
        $class = $class
            ->withParent('Enum')
            ->addUse(new Use_(Enum::class));

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
