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

namespace ApiPlatform\SchemaGenerator\Tests\AttributeGenerator;

use ApiPlatform\SchemaGenerator\AttributeGenerator\DoctrineOrmAttributeGenerator;
use ApiPlatform\SchemaGenerator\CardinalitiesExtractor;
use ApiPlatform\SchemaGenerator\Model\Class_;
use ApiPlatform\SchemaGenerator\Model\Property;
use ApiPlatform\SchemaGenerator\PhpTypeConverter;
use ApiPlatform\SchemaGenerator\TypesGenerator;
use Doctrine\Inflector\InflectorFactory;
use EasyRdf\Graph;
use EasyRdf\Resource;
use PHPUnit\Framework\TestCase;
use Psr\Log\NullLogger;

/**
 * @author Erik Saunier <erik.saunier@gmail.com>
 */
class DoctrineOrmAttributeGeneratorTest extends TestCase
{
    private DoctrineOrmAttributeGenerator $generator;

    private array $classMap = [];

    protected function setUp(): void
    {
        $graph = new Graph();

        $product = new Class_('Product', new Resource('https://schema.org/Product', $graph));
        $product->setIsAbstract(true);
        $this->classMap[$product->name()] = $product;

        $vehicle = new Class_('Vehicle', new Resource('htts://schema.org/Vehicle', $graph));
        $idProperty = new Property('id');
        $idProperty->rangeName = 'identifier';
        $idProperty->range = new Resource('https://schema.org/identifier');
        $idProperty->isId = true;
        $vehicle->addProperty($idProperty);
        $enumProperty = new Property('enum');
        $enumProperty->rangeName = 'Thing';
        $enumProperty->range = new Resource('https://schema.org/Thing');
        $enumProperty->isEnum = true;
        $enumProperty->isArray = true;
        $vehicle->addProperty($enumProperty);
        $collectionProperty = new Property('collection');
        $collectionProperty->rangeName = 'Thing';
        $collectionProperty->range = new Resource('https://schema.org/Thing');
        $collectionProperty->isArray = true;
        $vehicle->addProperty($collectionProperty);
        $weightProperty = new Property('weight');
        $weightProperty->rangeName = 'nonPositiveInteger';
        $weightProperty->range = new Resource('http://www.w3.org/2001/XMLSchema#nonPositiveInteger');
        $vehicle->addProperty($weightProperty);
        $prefixedWeightProperty = new Property('prefixedWeight');
        $prefixedWeightProperty->columnPrefix = 'weight_';
        $prefixedWeightProperty->isEmbedded = true;
        $prefixedWeightProperty->rangeName = 'QuantitativeValue';
        $prefixedWeightProperty->range = new Resource('https://schema.org/QuantitativeValue');
        $vehicle->addProperty($prefixedWeightProperty);
        $relation01Property = new Property('relation0_1');
        $relation01Property->rangeName = 'QuantitativeValue';
        $relation01Property->range = new Resource('https://schema.org/QuantitativeValue');
        $relation01Property->cardinality = CardinalitiesExtractor::CARDINALITY_0_1;
        $vehicle->addProperty($relation01Property);
        $relation11Property = new Property('relation1_1');
        $relation11Property->rangeName = 'QuantitativeValue';
        $relation11Property->range = new Resource('https://schema.org/QuantitativeValue');
        $relation11Property->cardinality = CardinalitiesExtractor::CARDINALITY_1_1;
        $vehicle->addProperty($relation11Property);
        $relationN0Property = new Property('relationN_0');
        $relationN0Property->rangeName = 'QuantitativeValue';
        $relationN0Property->range = new Resource('https://schema.org/QuantitativeValue');
        $relationN0Property->cardinality = CardinalitiesExtractor::CARDINALITY_N_0;
        $vehicle->addProperty($relationN0Property);
        $relationN1Property = new Property('relationN_1');
        $relationN1Property->rangeName = 'QuantitativeValue';
        $relationN1Property->range = new Resource('https://schema.org/QuantitativeValue');
        $relationN1Property->cardinality = CardinalitiesExtractor::CARDINALITY_N_1;
        $vehicle->addProperty($relationN1Property);
        $relation0NProperty = new Property('relation0_N');
        $relation0NProperty->rangeName = 'QuantitativeValue';
        $relation0NProperty->range = new Resource('https://schema.org/QuantitativeValue');
        $relation0NProperty->cardinality = CardinalitiesExtractor::CARDINALITY_0_N;
        $vehicle->addProperty($relation0NProperty);
        $relation1NProperty = new Property('relation1_N');
        $relation1NProperty->rangeName = 'QuantitativeValue';
        $relation1NProperty->range = new Resource('https://schema.org/QuantitativeValue');
        $relation1NProperty->cardinality = CardinalitiesExtractor::CARDINALITY_1_N;
        $vehicle->addProperty($relation1NProperty);
        $relationNNProperty = new Property('relationN_N');
        $relationNNProperty->rangeName = 'QuantitativeValue';
        $relationNNProperty->range = new Resource('https://schema.org/QuantitativeValue');
        $relationNNProperty->cardinality = CardinalitiesExtractor::CARDINALITY_N_N;
        $vehicle->addProperty($relationNNProperty);

        $this->classMap[$vehicle->name()] = $vehicle;

        $quantitativeValue = new Class_('QuantitativeValue', new Resource('https://schema.org/QuantitativeValue', $graph));
        $quantitativeValue->setEmbeddable(true);
        $this->classMap[$quantitativeValue->name()] = $quantitativeValue;

        $myEnum = new Resource('https://schema.org/MyEnum', $graph);
        $myEnum->add('rdfs:subClassOf', ['type' => 'uri', 'value' => TypesGenerator::SCHEMA_ORG_ENUMERATION]);
        $myEnumClass = new Class_('MyEnum', $myEnum);
        $this->classMap[$myEnumClass->name()] = $myEnumClass;

        $this->generator = new DoctrineOrmAttributeGenerator(
            new PhpTypeConverter(),
            new NullLogger(),
            InflectorFactory::create()->build(),
            [],
            [],
            ['id' => ['generationStrategy' => 'auto', 'writable' => true]],
            $this->classMap
        );
    }

    public function testGenerateClassAttributes(): void
    {
        $this->assertSame([], $this->generator->generateClassAttributes($this->classMap['MyEnum']));
        $this->assertSame([['ORM\MappedSuperclass' => []]], $this->generator->generateClassAttributes($this->classMap['Product']));
        $this->assertSame([['ORM\Entity' => []]], $this->generator->generateClassAttributes($this->classMap['Vehicle']));
        $this->assertSame([['ORM\Embeddable' => []]], $this->generator->generateClassAttributes($this->classMap['QuantitativeValue']));
    }

    public function testGenerateFieldAttributes(): void
    {
        $this->assertSame(
            [['ORM\Id' => []], ['ORM\Column' => ['type' => 'integer']]],
            $this->generator->generatePropertyAttributes($this->classMap['Vehicle']->getPropertyByName('id'), 'Vehicle')
        );
        $this->assertSame(
            [['ORM\Column' => ['type' => 'simple_array', 'nullable' => true]]],
            $this->generator->generatePropertyAttributes($this->classMap['Vehicle']->getPropertyByName('enum'), 'Vehicle')
        );
        $this->assertSame(
            [['ORM\Column' => ['type' => 'json', 'nullable' => true]]],
            $this->generator->generatePropertyAttributes($this->classMap['Vehicle']->getPropertyByName('collection'), 'Vehicle')
        );
        $this->assertSame(
            [['ORM\Column' => ['type' => 'integer', 'nullable' => true]]],
            $this->generator->generatePropertyAttributes($this->classMap['Vehicle']->getPropertyByName('weight'), 'Vehicle')
        );
        $this->assertSame(
            [['ORM\Embedded' => ['class' => 'QuantitativeValue', 'columnPrefix' => 'weight_']]],
            $this->generator->generatePropertyAttributes($this->classMap['Vehicle']->getPropertyByName('prefixedWeight'), 'Vehicle')
        );
        $this->assertSame(
            [['ORM\OneToOne' => ['targetEntity' => 'QuantitativeValue']]],
            $this->generator->generatePropertyAttributes($this->classMap['Vehicle']->getPropertyByName('relation0_1'), 'Vehicle')
        );
        $this->assertSame(
            [['ORM\OneToOne' => ['targetEntity' => 'QuantitativeValue']], ['ORM\JoinColumn' => ['nullable' => false]]],
            $this->generator->generatePropertyAttributes($this->classMap['Vehicle']->getPropertyByName('relation1_1'), 'Vehicle')
        );
        $this->assertSame(
            [['ORM\ManyToOne' => ['targetEntity' => 'QuantitativeValue']]],
            $this->generator->generatePropertyAttributes($this->classMap['Vehicle']->getPropertyByName('relationN_0'), 'Vehicle')
        );
        $this->assertSame(
            [['ORM\ManyToOne' => ['targetEntity' => 'QuantitativeValue']], ['ORM\JoinColumn' => ['nullable' => false]]],
            $this->generator->generatePropertyAttributes($this->classMap['Vehicle']->getPropertyByName('relationN_1'), 'Vehicle')
        );
        $this->assertSame(
            [['ORM\ManyToMany' => ['targetEntity' => 'QuantitativeValue']], ['ORM\InverseJoinColumn' => ['unique' => true]]],
            $this->generator->generatePropertyAttributes($this->classMap['Vehicle']->getPropertyByName('relation0_N'), 'Vehicle')
        );
        $this->assertSame(
            [['ORM\ManyToMany' => ['targetEntity' => 'QuantitativeValue']], ['ORM\InverseJoinColumn' => ['nullable' => false, 'unique' => true]]],
            $this->generator->generatePropertyAttributes($this->classMap['Vehicle']->getPropertyByName('relation1_N'), 'Vehicle')
        );
        $this->assertSame(
            [['ORM\ManyToMany' => ['targetEntity' => 'QuantitativeValue']]],
            $this->generator->generatePropertyAttributes($this->classMap['Vehicle']->getPropertyByName('relationN_N'), 'Vehicle')
        );
    }
}
