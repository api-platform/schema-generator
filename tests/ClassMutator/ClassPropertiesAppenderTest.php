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

namespace ApiPlatform\SchemaGenerator\Tests\ClassMutator;

use ApiPlatform\SchemaGenerator\CardinalitiesExtractor;
use ApiPlatform\SchemaGenerator\ClassMutator\ClassPropertiesAppender;
use ApiPlatform\SchemaGenerator\GoodRelationsBridge;
use ApiPlatform\SchemaGenerator\PhpTypeConverter;
use ApiPlatform\SchemaGenerator\Schema\Model\Class_ as SchemaClass;
use ApiPlatform\SchemaGenerator\Schema\Model\Property;
use ApiPlatform\SchemaGenerator\Schema\Model\Type\PrimitiveType as SchemaPrimitiveType;
use ApiPlatform\SchemaGenerator\Schema\PropertyGenerator\PropertyGenerator as SchemaPropertyGenerator;
use ApiPlatform\SchemaGenerator\Schema\TypeConverter;
use ApiPlatform\SchemaGenerator\SchemaGeneratorConfiguration;
use EasyRdf\Graph as RdfGraph;
use EasyRdf\Resource as RdfResource;
use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;
use Prophecy\Prophecy\ObjectProphecy;
use Psr\Log\LoggerInterface;
use Symfony\Component\Config\Definition\Processor;

class ClassPropertiesAppenderTest extends TestCase
{
    use ProphecyTrait;

    private RdfGraph $graph;
    private ObjectProphecy $loggerProphecy;
    private ClassPropertiesAppender $classPropertiesAppender;

    protected function setUp(): void
    {
        $this->loggerProphecy = $this->prophesize(LoggerInterface::class);

        $propertyGenerator = new SchemaPropertyGenerator(new GoodRelationsBridge([]), new TypeConverter(), new PhpTypeConverter());

        $configuration = new SchemaGeneratorConfiguration();
        $processedConfiguration = (new Processor())->processConfiguration($configuration, [[
            'types' => [
                'Person' => ['properties' => ['givenName' => []]],
            ],
        ]]);

        $this->graph ??= new RdfGraph();

        $this->graph->addResource('https://schema.org/articleBody', 'rdf:type', 'rdf:Property');
        $this->graph->addResource('https://schema.org/articleBody', 'schema:rangeIncludes', 'https://schema.org/Text');

        $this->graph->addResource('https://schema.org/articleSection', 'rdf:type', 'rdf:Property');
        $this->graph->addResource('https://schema.org/articleSection', 'schema:rangeIncludes', 'https://schema.org/Text');

        $this->graph->addResource('https://schema.org/givenName', 'rdf:type', 'rdfs:Property');
        $this->graph->addResource('https://schema.org/givenName', 'schema:rangeIncludes', 'https://schema.org/Text');

        $propertiesMap = [
            'https://schema.org/Article' => [new RdfResource('https://schema.org/articleBody', $this->graph), new RdfResource('https://schema.org/articleSection', $this->graph)],
            'https://schema.org/Person' => [new RdfResource('https://schema.org/givenName', $this->graph)],
        ];

        $this->classPropertiesAppender = new ClassPropertiesAppender($propertyGenerator, $processedConfiguration, $propertiesMap);
        $this->classPropertiesAppender->setLogger($this->loggerProphecy->reveal());
    }

    /**
     * @dataProvider provideInvokeTestCases
     */
    public function testInvoke(SchemaClass $class, SchemaClass $expectedClass, ?RdfGraph &$graph = null, ?string $loggerMessage = null): void
    {
        if ($graph) {
            $this->graph = $graph;
            $this->setUp();
        }

        if ($loggerMessage) {
            $this->loggerProphecy->warning($loggerMessage)->shouldBeCalled();
        }

        ($this->classPropertiesAppender)($class, ['graphs' => [], 'cardinalities' => []]);

        $this->assertEquals($expectedClass, $class);
    }

    /**
     * @return \Generator<array{0: SchemaClass, 1: SchemaClass, 2?: ?RdfGraph, 3?: string}>
     */
    public function provideInvokeTestCases(): \Generator
    {
        $product = new SchemaClass('Product', new RdfResource('https://schema.org/Product'));
        yield 'no configuration no properties in map' => [clone $product, clone $product, null, 'Properties for "https://schema.org/Product" not found in the map.'];

        $article = new SchemaClass('Article', new RdfResource('https://schema.org/Article'));
        $graph = new RdfGraph();
        $expectedArticleBodyProperty = new Property('articleBody');
        $expectedArticleBodyProperty->cardinality = CardinalitiesExtractor::CARDINALITY_UNKNOWN;
        $expectedArticleBodyProperty->resource = new RdfResource('https://schema.org/articleBody', $graph);
        $expectedArticleBodyProperty->range = new RdfResource('https://schema.org/Text', $graph);
        $expectedArticleBodyProperty->rangeName = 'Text';
        $expectedArticleBodyProperty->type = new SchemaPrimitiveType('string');
        $expectedArticleBodyProperty->isNullable = true;
        $expectedArticleSectionProperty = new Property('articleSection');
        $expectedArticleSectionProperty->cardinality = CardinalitiesExtractor::CARDINALITY_UNKNOWN;
        $expectedArticleSectionProperty->resource = new RdfResource('https://schema.org/articleSection', $graph);
        $expectedArticleSectionProperty->range = new RdfResource('https://schema.org/Text', $graph);
        $expectedArticleSectionProperty->rangeName = 'Text';
        $expectedArticleSectionProperty->type = new SchemaPrimitiveType('string');
        $expectedArticleSectionProperty->isNullable = true;
        yield 'no configuration' => [clone $article, (clone $article)->addProperty($expectedArticleBodyProperty)->addProperty($expectedArticleSectionProperty), $graph];

        $graph = new RdfGraph();
        $person = new SchemaClass('Person', new RdfResource('https://schema.org/Person', $graph));
        $expectedGivenNameProperty = new Property('givenName');
        $expectedGivenNameProperty->cardinality = CardinalitiesExtractor::CARDINALITY_UNKNOWN;
        $expectedGivenNameProperty->resource = new RdfResource('https://schema.org/givenName', $graph);
        $expectedGivenNameProperty->range = new RdfResource('https://schema.org/Text', $graph);
        $expectedGivenNameProperty->rangeName = 'Text';
        $expectedGivenNameProperty->type = new SchemaPrimitiveType('string');
        $expectedGivenNameProperty->isNullable = true;
        $expectedGivenNameProperty->isRequired = true;
        yield 'with configuration' => [clone $person, (clone $person)->addProperty($expectedGivenNameProperty), $graph];
    }
}
