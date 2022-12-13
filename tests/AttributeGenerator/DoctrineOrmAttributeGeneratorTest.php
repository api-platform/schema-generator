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
use ApiPlatform\SchemaGenerator\Model\Type\ArrayType;
use ApiPlatform\SchemaGenerator\PhpTypeConverter;
use ApiPlatform\SchemaGenerator\Schema\Model\Class_ as SchemaClass;
use ApiPlatform\SchemaGenerator\Schema\Model\Property;
use ApiPlatform\SchemaGenerator\Schema\Model\Type\PrimitiveType as SchemaPrimitiveType;
use ApiPlatform\SchemaGenerator\SchemaGeneratorConfiguration;
use ApiPlatform\SchemaGenerator\TypesGenerator;
use EasyRdf\Graph as RdfGraph;
use EasyRdf\Resource as RdfResource;
use Nette\PhpGenerator\Literal;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Config\Definition\Processor;
use Symfony\Component\String\Inflector\EnglishInflector;

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

        $thing = new SchemaClass('Thing', new RdfResource('https://schema.org/Thing', $graph));
        $thing->isAbstract = true;
        $thing->hasChild = true;
        $this->classMap[$thing->name()] = $thing;

        $organization = new SchemaClass('Organization', new RdfResource('https://schema.org/Organization', $graph));
        $this->classMap[$organization->name()] = $organization;

        $product = new SchemaClass('Product', new RdfResource('https://schema.org/Product', $graph), 'Thing');
        $product->hasChild = true;
        $product->isReferencedBy = [$organization];
        $this->classMap[$product->name()] = $product;

        $vehicle = new SchemaClass('Vehicle', new RdfResource('htts://schema.org/Vehicle', $graph), 'Product');
        $vehicle->hasChild = true;
        $vehicle->isAbstract = true;
        $idProperty = new Property('id');
        $idProperty->rangeName = 'identifier';
        $idProperty->range = new RdfResource('https://schema.org/identifier');
        $idProperty->type = new SchemaPrimitiveType('string');
        $idProperty->isId = true;
        $vehicle->addProperty($idProperty);
        $enumProperty = new Property('enum');
        $enumProperty->rangeName = 'Thing';
        $enumProperty->range = new RdfResource('https://schema.org/Thing');
        $enumProperty->isEnum = true;
        $enumProperty->type = new ArrayType();
        $enumProperty->reference = new SchemaClass('Thing', new RdfResource('htts://schema.org/Thing', $graph));
        $vehicle->addProperty($enumProperty);
        $collectionProperty = new Property('collection');
        $collectionProperty->rangeName = 'string';
        $collectionProperty->range = new RdfResource('http://www.w3.org/2001/XMLSchema#string');
        $collectionProperty->type = new ArrayType(new SchemaPrimitiveType('string'));
        $vehicle->addProperty($collectionProperty);
        $weightProperty = new Property('weight');
        $weightProperty->rangeName = 'nonPositiveInteger';
        $weightProperty->range = new RdfResource('http://www.w3.org/2001/XMLSchema#nonPositiveInteger');
        $weightProperty->type = new SchemaPrimitiveType('nonPositiveInteger');
        $vehicle->addProperty($weightProperty);
        $prefixedWeightProperty = new Property('prefixedWeight');
        $prefixedWeightProperty->isEmbedded = true;
        $prefixedWeightProperty->rangeName = 'QuantitativeValue';
        $prefixedWeightProperty->range = new RdfResource('https://schema.org/QuantitativeValue');
        $prefixedWeightProperty->reference = new SchemaClass('QuantitativeValue', new RdfResource('htts://schema.org/QuantitativeValue', $graph));
        $vehicle->addProperty($prefixedWeightProperty);
        $productProperty = new Property('product');
        $productProperty->rangeName = 'Product';
        $productProperty->range = new RdfResource('https://schema.org/Product');
        $productProperty->reference = $product;
        $vehicle->addProperty($productProperty);
        $relation01Property = new Property('relation0_1');
        $relation01Property->rangeName = 'QuantitativeValue';
        $relation01Property->range = new RdfResource('https://schema.org/QuantitativeValue');
        $relation01Property->reference = new SchemaClass('QuantitativeValue', new RdfResource('htts://schema.org/QuantitativeValue', $graph));
        $relation01Property->cardinality = CardinalitiesExtractor::CARDINALITY_0_1;
        $vehicle->addProperty($relation01Property);
        $relation11Property = new Property('relation1_1');
        $relation11Property->rangeName = 'QuantitativeValue';
        $relation11Property->range = new RdfResource('https://schema.org/QuantitativeValue');
        $relation11Property->reference = new SchemaClass('QuantitativeValue', new RdfResource('htts://schema.org/QuantitativeValue', $graph));
        $relation11Property->cardinality = CardinalitiesExtractor::CARDINALITY_1_1;
        $vehicle->addProperty($relation11Property);
        $relationN0Property = new Property('relationN_0');
        $relationN0Property->rangeName = 'QuantitativeValue';
        $relationN0Property->range = new RdfResource('https://schema.org/QuantitativeValue');
        $relationN0Property->reference = new SchemaClass('QuantitativeValue', new RdfResource('htts://schema.org/QuantitativeValue', $graph));
        $relationN0Property->cardinality = CardinalitiesExtractor::CARDINALITY_N_0;
        $vehicle->addProperty($relationN0Property);
        $relationN1Property = new Property('relationN_1');
        $relationN1Property->rangeName = 'QuantitativeValue';
        $relationN1Property->range = new RdfResource('https://schema.org/QuantitativeValue');
        $relationN1Property->reference = new SchemaClass('QuantitativeValue', new RdfResource('htts://schema.org/QuantitativeValue', $graph));
        $relationN1Property->cardinality = CardinalitiesExtractor::CARDINALITY_N_1;
        $vehicle->addProperty($relationN1Property);
        $relation0NProperty = new Property('relation0_N');
        $relation0NProperty->rangeName = 'QuantitativeValue';
        $relation0NProperty->range = new RdfResource('https://schema.org/QuantitativeValue');
        $relation0NProperty->reference = new SchemaClass('QuantitativeValue', new RdfResource('htts://schema.org/QuantitativeValue', $graph));
        $relation0NProperty->cardinality = CardinalitiesExtractor::CARDINALITY_0_N;
        $relation0NProperty->type = new ArrayType();
        $vehicle->addProperty($relation0NProperty);
        $relation1NProperty = new Property('relation1_N');
        $relation1NProperty->rangeName = 'QuantitativeValue';
        $relation1NProperty->range = new RdfResource('https://schema.org/QuantitativeValue');
        $relation1NProperty->reference = new SchemaClass('QuantitativeValue', new RdfResource('htts://schema.org/QuantitativeValue', $graph));
        $relation1NProperty->cardinality = CardinalitiesExtractor::CARDINALITY_1_N;
        $relation1NProperty->type = new ArrayType();
        $vehicle->addProperty($relation1NProperty);
        $relation1NSelfReferencingProperty = new Property('relation1_N_self_referencing');
        $relation1NSelfReferencingProperty->rangeName = 'Vehicle';
        $relation1NSelfReferencingProperty->range = new RdfResource('https://schema.org/Vehicle');
        $relation1NSelfReferencingProperty->reference = new SchemaClass('Vehicle', new RdfResource('htts://schema.org/Vehicle', $graph));
        $relation1NSelfReferencingProperty->cardinality = CardinalitiesExtractor::CARDINALITY_1_N;
        $relation1NSelfReferencingProperty->type = new ArrayType();
        $vehicle->addProperty($relation1NSelfReferencingProperty);
        $relationNNProperty = new Property('relationN_N');
        $relationNNProperty->rangeName = 'QuantitativeValue';
        $relationNNProperty->range = new RdfResource('https://schema.org/QuantitativeValue');
        $relationNNProperty->reference = new SchemaClass('QuantitativeValue', new RdfResource('htts://schema.org/QuantitativeValue', $graph));
        $relationNNProperty->cardinality = CardinalitiesExtractor::CARDINALITY_N_N;
        $relationNNProperty->type = new ArrayType();
        $vehicle->addProperty($relationNNProperty);

        $this->classMap[$vehicle->name()] = $vehicle;

        $car = new SchemaClass('Car', new RdfResource('https://schema.org/Car', $graph), 'Vehicle');
        $this->classMap[$car->name()] = $car;

        $quantitativeValue = new SchemaClass('QuantitativeValue', new RdfResource('https://schema.org/QuantitativeValue', $graph));
        $quantitativeValue->isEmbeddable = true;
        $this->classMap[$quantitativeValue->name()] = $quantitativeValue;

        $myEnum = new RdfResource('https://schema.org/MyEnum', $graph);
        $myEnum->add('rdfs:subClassOf', ['type' => 'uri', 'value' => TypesGenerator::SCHEMA_ORG_ENUMERATION]);
        $myEnumClass = new SchemaClass('MyEnum', $myEnum);
        $this->classMap[$myEnumClass->name()] = $myEnumClass;

        $configuration = new SchemaGeneratorConfiguration();
        /** @var Configuration $processedConfiguration */
        $processedConfiguration = (new Processor())->processConfiguration($configuration, [[
            'id' => ['generationStrategy' => 'auto', 'writable' => true],
            'types' => [
                'Product' => null,
                // Vehicle is not added deliberately
            ],
        ]]);

        $this->generator = new DoctrineOrmAttributeGenerator(
            new PhpTypeConverter(),
            new EnglishInflector(),
            $processedConfiguration,
            $this->classMap
        );
    }

    public function testGenerateClassAttributes(): void
    {
        $this->assertSame([], $this->generator->generateClassAttributes($this->classMap['MyEnum']));
        $this->assertEquals([new Attribute('ORM\MappedSuperclass')], $this->generator->generateClassAttributes($this->classMap['Thing']));
        $this->assertEquals([
            new Attribute('ORM\Entity'),
            new Attribute('ORM\InheritanceType', ['JOINED']),
            new Attribute('ORM\DiscriminatorColumn', ['name' => 'discr']),
            new Attribute('ORM\DiscriminatorMap', [['product' => new Literal('Product::class'), 'car' => new Literal('Car::class')]]),
        ], $this->generator->generateClassAttributes($this->classMap['Product']));
        $this->assertEquals([new Attribute('ORM\Entity')], $this->generator->generateClassAttributes($this->classMap['Car']));
        $this->assertEquals([new Attribute('ORM\Embeddable')], $this->generator->generateClassAttributes($this->classMap['QuantitativeValue']));
    }

    public function testGeneratePropertyAttributes(): void
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
            [new Attribute('ORM\Column', ['type' => 'json', 'nullable' => true, 'name' => '`collection`'])],
            $this->generator->generatePropertyAttributes($this->classMap['Vehicle']->getPropertyByName('collection'), 'Vehicle')
        );
        $this->assertEquals(
            [new Attribute('ORM\Column', ['type' => 'integer', 'nullable' => true])],
            $this->generator->generatePropertyAttributes($this->classMap['Vehicle']->getPropertyByName('weight'), 'Vehicle')
        );
        $this->assertEquals(
            [new Attribute('ORM\Embedded', ['class' => 'App\Entity\QuantitativeValue'])],
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
            [new Attribute('ORM\ManyToMany', ['targetEntity' => 'App\Entity\QuantitativeValue']), new Attribute('ORM\JoinTable', ['name' => 'vehicle_quantitative_value_relation0_n']), new Attribute('ORM\InverseJoinColumn', ['unique' => true])],
            $this->generator->generatePropertyAttributes($this->classMap['Vehicle']->getPropertyByName('relation0_N'), 'Vehicle')
        );
        $this->assertEquals(
            [new Attribute('ORM\ManyToMany', ['targetEntity' => 'App\Entity\QuantitativeValue']), new Attribute('ORM\JoinTable', ['name' => 'vehicle_quantitative_value_relation1_n']), new Attribute('ORM\InverseJoinColumn', ['nullable' => false, 'unique' => true])],
            $this->generator->generatePropertyAttributes($this->classMap['Vehicle']->getPropertyByName('relation1_N'), 'Vehicle')
        );
        $this->assertEquals(
            [new Attribute('ORM\ManyToMany', ['targetEntity' => 'App\Entity\Vehicle']), new Attribute('ORM\JoinTable', ['name' => 'vehicle_vehicle_relation1_n_self_referencing']), new Attribute('ORM\InverseJoinColumn', ['name' => 'relation1_n_self_referencing_vehicle_id', 'nullable' => false, 'unique' => true])],
            $this->generator->generatePropertyAttributes($this->classMap['Vehicle']->getPropertyByName('relation1_N_self_referencing'), 'Vehicle')
        );
        $this->assertEquals(
            [new Attribute('ORM\ManyToMany', ['targetEntity' => 'App\Entity\QuantitativeValue']), new Attribute('ORM\JoinTable', ['name' => 'vehicle_quantitative_value_relation_nn'])],
            $this->generator->generatePropertyAttributes($this->classMap['Vehicle']->getPropertyByName('relationN_N'), 'Vehicle')
        );
    }
}
