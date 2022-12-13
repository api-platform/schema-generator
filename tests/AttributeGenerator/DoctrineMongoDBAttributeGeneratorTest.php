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

use ApiPlatform\SchemaGenerator\AttributeGenerator\DoctrineMongoDBAttributeGenerator;
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

class DoctrineMongoDBAttributeGeneratorTest extends TestCase
{
    private DoctrineMongoDBAttributeGenerator $generator;

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
        $enumProperty->reference = new SchemaClass('Thing', new RdfResource('htts://schema.org/Thing', $graph));
        $enumProperty->isEnum = true;
        $enumProperty->type = new ArrayType();
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
        $productProperty = new Property('product');
        $productProperty->rangeName = 'Product';
        $productProperty->range = new RdfResource('https://schema.org/Product');
        $productProperty->reference = $product;
        $vehicle->addProperty($productProperty);
        $relationProperty = new Property('relation');
        $relationProperty->rangeName = 'Person';
        $relationProperty->range = new RdfResource('https://schema.org/Person');
        $relationProperty->reference = new SchemaClass('Person', new RdfResource('htts://schema.org/Person', $graph));
        $relationProperty->cardinality = CardinalitiesExtractor::CARDINALITY_1_1;
        $vehicle->addProperty($relationProperty);
        $relationsProperty = new Property('relations');
        $relationsProperty->rangeName = 'Person';
        $relationsProperty->range = new RdfResource('https://schema.org/Person');
        $relationsProperty->reference = new SchemaClass('Person', new RdfResource('htts://schema.org/Person', $graph));
        $relationsProperty->cardinality = CardinalitiesExtractor::CARDINALITY_1_N;
        $relationsProperty->type = new ArrayType();
        $vehicle->addProperty($relationsProperty);

        $this->classMap[$vehicle->name()] = $vehicle;

        $car = new SchemaClass('Car', new RdfResource('https://schema.org/Car', $graph), 'Vehicle');
        $this->classMap[$car->name()] = $car;

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

        $this->generator = new DoctrineMongoDBAttributeGenerator(
            new PhpTypeConverter(),
            new EnglishInflector(),
            $processedConfiguration,
            $this->classMap
        );
    }

    public function testGenerateClassAttributes(): void
    {
        $this->assertSame([], $this->generator->generateClassAttributes($this->classMap['MyEnum']));
        $this->assertEquals([new Attribute('MongoDB\MappedSuperclass')], $this->generator->generateClassAttributes($this->classMap['Thing']));
        $this->assertEquals([
            new Attribute('MongoDB\Document'),
            new Attribute('MongoDB\InheritanceType', ['SINGLE_COLLECTION']),
            new Attribute('MongoDB\DiscriminatorField', ['discr']),
            new Attribute('MongoDB\DiscriminatorMap', [['product' => new Literal('Product::class'), 'car' => new Literal('Car::class')]]),
        ], $this->generator->generateClassAttributes($this->classMap['Product']));
        $this->assertEquals([new Attribute('MongoDB\Document')], $this->generator->generateClassAttributes($this->classMap['Car']));
    }

    public function testGeneratePropertyAttributes(): void
    {
        $this->assertEquals(
            [new Attribute('MongoDB\Id', ['strategy' => 'INCREMENT'])],
            $this->generator->generatePropertyAttributes($this->classMap['Vehicle']->getPropertyByName('id'), 'Vehicle')
        );
        $this->assertEquals(
            [new Attribute('MongoDB\Field', ['type' => 'simple_array'])],
            $this->generator->generatePropertyAttributes($this->classMap['Vehicle']->getPropertyByName('enum'), 'Vehicle')
        );
        $this->assertEquals(
            [new Attribute('MongoDB\Field', ['type' => 'collection'])],
            $this->generator->generatePropertyAttributes($this->classMap['Vehicle']->getPropertyByName('collection'), 'Vehicle')
        );
        $this->assertEquals(
            [new Attribute('MongoDB\Field', ['type' => 'integer'])],
            $this->generator->generatePropertyAttributes($this->classMap['Vehicle']->getPropertyByName('weight'), 'Vehicle')
        );
        $this->assertEquals(
            [new Attribute('MongoDB\ReferenceOne', ['targetDocument' => 'Person'])],
            $this->generator->generatePropertyAttributes($this->classMap['Vehicle']->getPropertyByName('relation'), 'Vehicle')
        );
        $this->assertEquals(
            [new Attribute('MongoDB\ReferenceMany', ['targetDocument' => 'Person'])],
            $this->generator->generatePropertyAttributes($this->classMap['Vehicle']->getPropertyByName('relations'), 'Vehicle')
        );
    }
}
