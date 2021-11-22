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
use ApiPlatform\SchemaGenerator\Model\Attribute;
use ApiPlatform\SchemaGenerator\Model\Class_;
use ApiPlatform\SchemaGenerator\Model\Property;
use ApiPlatform\SchemaGenerator\PhpTypeConverter;
use ApiPlatform\SchemaGenerator\TypesGenerator;
use ApiPlatform\SchemaGenerator\TypesGeneratorConfiguration;
use Doctrine\Inflector\InflectorFactory;
use EasyRdf\Graph as RdfGraph;
use EasyRdf\Resource as RdfResource;
use PHPUnit\Framework\TestCase;
use Psr\Log\NullLogger;
use Symfony\Component\Config\Definition\Processor;

/**
 * @author Erik Saunier <erik.saunier@gmail.com>
 */
class DoctrineOrmAttributeGeneratorTest extends TestCase
{
    private DoctrineOrmAttributeGenerator $generator;

    private array $classMap = [];

    protected function setUp(): void
    {
        $graph = new RdfGraph();

        $product = new Class_('Product', new RdfResource('https://schema.org/Product', $graph));
        $product->isAbstract = true;
        $this->classMap[$product->name()] = $product;

        $vehicle = new Class_('Vehicle', new RdfResource('htts://schema.org/Vehicle', $graph));
        $idProperty = new Property('id');
        $idProperty->rangeName = 'identifier';
        $idProperty->range = new RdfResource('https://schema.org/identifier');
        $idProperty->isId = true;
        $vehicle->addProperty($idProperty);
        $enumProperty = new Property('enum');
        $enumProperty->rangeName = 'Thing';
        $enumProperty->range = new RdfResource('https://schema.org/Thing');
        $enumProperty->isEnum = true;
        $enumProperty->isArray = true;
        $vehicle->addProperty($enumProperty);
        $collectionProperty = new Property('collection');
        $collectionProperty->rangeName = 'Thing';
        $collectionProperty->range = new RdfResource('https://schema.org/Thing');
        $collectionProperty->isArray = true;
        $vehicle->addProperty($collectionProperty);
        $weightProperty = new Property('weight');
        $weightProperty->rangeName = 'nonPositiveInteger';
        $weightProperty->range = new RdfResource('http://www.w3.org/2001/XMLSchema#nonPositiveInteger');
        $vehicle->addProperty($weightProperty);
        $prefixedWeightProperty = new Property('prefixedWeight');
        $prefixedWeightProperty->columnPrefix = 'weight_';
        $prefixedWeightProperty->isEmbedded = true;
        $prefixedWeightProperty->rangeName = 'QuantitativeValue';
        $prefixedWeightProperty->range = new RdfResource('https://schema.org/QuantitativeValue');
        $vehicle->addProperty($prefixedWeightProperty);
        $relation01Property = new Property('relation0_1');
        $relation01Property->rangeName = 'QuantitativeValue';
        $relation01Property->range = new RdfResource('https://schema.org/QuantitativeValue');
        $relation01Property->cardinality = CardinalitiesExtractor::CARDINALITY_0_1;
        $vehicle->addProperty($relation01Property);
        $relation11Property = new Property('relation1_1');
        $relation11Property->rangeName = 'QuantitativeValue';
        $relation11Property->range = new RdfResource('https://schema.org/QuantitativeValue');
        $relation11Property->cardinality = CardinalitiesExtractor::CARDINALITY_1_1;
        $vehicle->addProperty($relation11Property);
        $relationN0Property = new Property('relationN_0');
        $relationN0Property->rangeName = 'QuantitativeValue';
        $relationN0Property->range = new RdfResource('https://schema.org/QuantitativeValue');
        $relationN0Property->cardinality = CardinalitiesExtractor::CARDINALITY_N_0;
        $vehicle->addProperty($relationN0Property);
        $relationN1Property = new Property('relationN_1');
        $relationN1Property->rangeName = 'QuantitativeValue';
        $relationN1Property->range = new RdfResource('https://schema.org/QuantitativeValue');
        $relationN1Property->cardinality = CardinalitiesExtractor::CARDINALITY_N_1;
        $vehicle->addProperty($relationN1Property);
        $relation0NProperty = new Property('relation0_N');
        $relation0NProperty->rangeName = 'QuantitativeValue';
        $relation0NProperty->range = new RdfResource('https://schema.org/QuantitativeValue');
        $relation0NProperty->cardinality = CardinalitiesExtractor::CARDINALITY_0_N;
        $vehicle->addProperty($relation0NProperty);
        $relation1NProperty = new Property('relation1_N');
        $relation1NProperty->rangeName = 'QuantitativeValue';
        $relation1NProperty->range = new RdfResource('https://schema.org/QuantitativeValue');
        $relation1NProperty->cardinality = CardinalitiesExtractor::CARDINALITY_1_N;
        $vehicle->addProperty($relation1NProperty);
        $relationNNProperty = new Property('relationN_N');
        $relationNNProperty->rangeName = 'QuantitativeValue';
        $relationNNProperty->range = new RdfResource('https://schema.org/QuantitativeValue');
        $relationNNProperty->cardinality = CardinalitiesExtractor::CARDINALITY_N_N;
        $vehicle->addProperty($relationNNProperty);

        $this->classMap[$vehicle->name()] = $vehicle;

        $quantitativeValue = new Class_('QuantitativeValue', new RdfResource('https://schema.org/QuantitativeValue', $graph));
        $quantitativeValue->isEmbeddable = true;
        $this->classMap[$quantitativeValue->name()] = $quantitativeValue;

        $myEnum = new RdfResource('https://schema.org/MyEnum', $graph);
        $myEnum->add('rdfs:subClassOf', ['type' => 'uri', 'value' => TypesGenerator::SCHEMA_ORG_ENUMERATION]);
        $myEnumClass = new Class_('MyEnum', $myEnum);
        $this->classMap[$myEnumClass->name()] = $myEnumClass;

        $customAttributes = new RdfResource('https://schema.org/CustomAttributes', $graph);
        $customAttributesClass = new Class_('CustomAttributes', $customAttributes);
        $this->classMap[$customAttributesClass->name()] = $customAttributesClass;

        $configuration = new TypesGeneratorConfiguration();
        /** @var Configuration $processedConfiguration */
        $processedConfiguration = (new Processor())->processConfiguration($configuration, [[
            'id' => ['generationStrategy' => 'auto', 'writable' => true],
            'types' => [
                'CustomAttributes' => ['doctrine' => ['attributes' => ['ORM\Entity' => ['readOnly' => true]]]],
                'Product' => null,
                // Vehicle is not added deliberately
            ],
        ]]);

        $this->generator = new DoctrineOrmAttributeGenerator(
            new PhpTypeConverter(),
            new NullLogger(),
            InflectorFactory::create()->build(),
            [],
            [],
            $processedConfiguration,
            $this->classMap
        );
    }

    public function testGenerateClassAttributes(): void
    {
        $this->assertSame([], $this->generator->generateClassAttributes($this->classMap['MyEnum']));
        $this->assertEquals([new Attribute('ORM\Entity', ['readOnly' => true])], $this->generator->generateClassAttributes($this->classMap['CustomAttributes']));
        $this->assertEquals([new Attribute('ORM\MappedSuperclass')], $this->generator->generateClassAttributes($this->classMap['Product']));
        $this->assertEquals([new Attribute('ORM\Entity')], $this->generator->generateClassAttributes($this->classMap['Vehicle']));
        $this->assertEquals([new Attribute('ORM\Embeddable')], $this->generator->generateClassAttributes($this->classMap['QuantitativeValue']));
    }

    public function testGenerateFieldAttributes(): void
    {
        $this->assertEquals(
            [new Attribute('ORM\Id'), new Attribute('ORM\Column', ['type' => 'integer'])],
            $this->generator->generatePropertyAttributes($this->classMap['Vehicle']->getPropertyByName('id'), 'Vehicle')
        );
        $this->assertEquals(
            [new Attribute('ORM\Column', ['type' => 'simple_array', 'nullable' => true])],
            $this->generator->generatePropertyAttributes($this->classMap['Vehicle']->getPropertyByName('enum'), 'Vehicle')
        );
        $this->assertEquals(
            [new Attribute('ORM\Column', ['type' => 'json', 'nullable' => true])],
            $this->generator->generatePropertyAttributes($this->classMap['Vehicle']->getPropertyByName('collection'), 'Vehicle')
        );
        $this->assertEquals(
            [new Attribute('ORM\Column', ['type' => 'integer', 'nullable' => true])],
            $this->generator->generatePropertyAttributes($this->classMap['Vehicle']->getPropertyByName('weight'), 'Vehicle')
        );
        $this->assertEquals(
            [new Attribute('ORM\Embedded', ['class' => 'App\Entity\QuantitativeValue', 'columnPrefix' => 'weight_'])],
            $this->generator->generatePropertyAttributes($this->classMap['Vehicle']->getPropertyByName('prefixedWeight'), 'Vehicle')
        );
        $this->assertEquals(
            [new Attribute('ORM\OneToOne', ['targetEntity' => 'App\Entity\QuantitativeValue'])],
            $this->generator->generatePropertyAttributes($this->classMap['Vehicle']->getPropertyByName('relation0_1'), 'Vehicle')
        );
        $this->assertEquals(
            [new Attribute('ORM\OneToOne', ['targetEntity' => 'App\Entity\QuantitativeValue']), new Attribute('ORM\JoinColumn', ['nullable' => false])],
            $this->generator->generatePropertyAttributes($this->classMap['Vehicle']->getPropertyByName('relation1_1'), 'Vehicle')
        );
        $this->assertEquals(
            [new Attribute('ORM\ManyToOne', ['targetEntity' => 'App\Entity\QuantitativeValue'])],
            $this->generator->generatePropertyAttributes($this->classMap['Vehicle']->getPropertyByName('relationN_0'), 'Vehicle')
        );
        $this->assertEquals(
            [new Attribute('ORM\ManyToOne', ['targetEntity' => 'App\Entity\QuantitativeValue']), new Attribute('ORM\JoinColumn', ['nullable' => false])],
            $this->generator->generatePropertyAttributes($this->classMap['Vehicle']->getPropertyByName('relationN_1'), 'Vehicle')
        );
        $this->assertEquals(
            [new Attribute('ORM\ManyToMany', ['targetEntity' => 'App\Entity\QuantitativeValue']), new Attribute('ORM\InverseJoinColumn', ['unique' => true])],
            $this->generator->generatePropertyAttributes($this->classMap['Vehicle']->getPropertyByName('relation0_N'), 'Vehicle')
        );
        $this->assertEquals(
            [new Attribute('ORM\ManyToMany', ['targetEntity' => 'App\Entity\QuantitativeValue']), new Attribute('ORM\InverseJoinColumn', ['nullable' => false, 'unique' => true])],
            $this->generator->generatePropertyAttributes($this->classMap['Vehicle']->getPropertyByName('relation1_N'), 'Vehicle')
        );
        $this->assertEquals(
            [new Attribute('ORM\ManyToMany', ['targetEntity' => 'App\Entity\QuantitativeValue'])],
            $this->generator->generatePropertyAttributes($this->classMap['Vehicle']->getPropertyByName('relationN_N'), 'Vehicle')
        );
    }
}
