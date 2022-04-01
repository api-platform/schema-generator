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

namespace ApiPlatform\SchemaGenerator\Schema\ClassMutator;

use ApiPlatform\SchemaGenerator\ClassMutator\EnumClassMutator as BaseEnumClassMutator;
use ApiPlatform\SchemaGenerator\Model\Class_;
use ApiPlatform\SchemaGenerator\PhpTypeConverterInterface;
use ApiPlatform\SchemaGenerator\Schema\Model\Constant as SchemaConstant;
use EasyRdf\Graph as RdfGraph;

final class EnumClassMutator extends BaseEnumClassMutator
{
    /**
     * @var RdfGraph[]
     */
    private array $graphs;

    /**
     * @param RdfGraph[] $graphs
     */
    public function __construct(PhpTypeConverterInterface $phpTypeConverter, array $graphs, string $desiredNamespace)
    {
        parent::__construct($phpTypeConverter, $desiredNamespace);

        $this->graphs = $graphs;
    }

    protected function addEnumConstants(Class_ $class): void
    {
        if (!$class->rdfType()) {
            return;
        }

        foreach ($this->graphs as $graph) {
            foreach ($graph->allOfType($class->rdfType()) as $instance) {
                $class->addConstant($instance->localName(), new SchemaConstant(
                    $this->phpTypeConverter->escapeIdentifier(strtoupper(substr(preg_replace('/([A-Z])/', '_$1', $instance->localName()), 1))),
                    $instance
                ));
            }
        }
    }
}
