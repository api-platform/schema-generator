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

class DoctrineMongoDBAttributeGeneratorTest extends TestCase
{
    private DoctrineMongoDBAttributeGenerator $generator;

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
        $relationProperty = new Property('relation');
        $relationProperty->rangeName = 'Person';
        $relationProperty->range = new RdfResource('https://schema.org/Person');
        $relationProperty->cardinality = CardinalitiesExtractor::CARDINALITY_1_1;
        $vehicle->addProperty($relationProperty);
        $relationsProperty = new Property('relations');
        $relationsProperty->rangeName = 'Person';
        $relationsProperty->range = new RdfResource('https://schema.org/Person');
        $relationsProperty->cardinality = CardinalitiesExtractor::CARDINALITY_1_N;
        $vehicle->addProperty($relationsProperty);

        $this->classMap[$vehicle->name()] = $vehicle;

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
                'CustomAttributes' => ['doctrine' => ['attributes' => ['MongoDB\Document' => ['db' => 'my_db']]]],
                'Product' => null,
                // Vehicle is not added deliberately
            ],
        ]]);

        $this->generator = new DoctrineMongoDBAttributeGenerator(
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
        $this->assertEquals([new Attribute('MongoDB\Document', ['db' => 'my_db'])], $this->generator->generateClassAttributes($this->classMap['CustomAttributes']));
        $this->assertEquals([new Attribute('MongoDB\MappedSuperclass')], $this->generator->generateClassAttributes($this->classMap['Product']));
        $this->assertEquals([new Attribute('MongoDB\Document')], $this->generator->generateClassAttributes($this->classMap['Vehicle']));
    }

    public function testGenerateFieldAttributes(): void
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
            [new Attribute('MongoDB\ReferenceOne', ['targetDocument' => 'Person', 'simple' => true])],
            $this->generator->generatePropertyAttributes($this->classMap['Vehicle']->getPropertyByName('relation'), 'Vehicle')
        );
        $this->assertEquals(
            [new Attribute('MongoDB\ReferenceMany', ['targetDocument' => 'Person', 'simple' => true])],
            $this->generator->generatePropertyAttributes($this->classMap['Vehicle']->getPropertyByName('relations'), 'Vehicle')
        );
    }
}
