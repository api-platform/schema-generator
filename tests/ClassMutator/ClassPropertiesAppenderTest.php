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
use ApiPlatform\SchemaGenerator\Model\Class_;
use ApiPlatform\SchemaGenerator\Model\Property;
use ApiPlatform\SchemaGenerator\PhpTypeConverter;
use ApiPlatform\SchemaGenerator\PropertyGenerator\PropertyGenerator;
use ApiPlatform\SchemaGenerator\TypesGeneratorConfiguration;
use EasyRdf\Graph as RdfGraph;
use EasyRdf\Resource as RdfResource;
use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;
use Prophecy\Prophecy\ObjectProphecy;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;
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

        $propertyGenerator = new PropertyGenerator(new GoodRelationsBridge([]), new PhpTypeConverter(), [], new NullLogger());

        $configuration = new TypesGeneratorConfiguration();
        /** @var Configuration $processedConfiguration */
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

        $this->classPropertiesAppender = new ClassPropertiesAppender($propertyGenerator, $this->loggerProphecy->reveal(), $processedConfiguration, $propertiesMap, []);
    }

    /**
     * @dataProvider provideInvokeTestCases
     */
    public function testInvoke(Class_ $class, Class_ $expectedClass, RdfGraph &$graph = null, ?string $loggerMessage = null): void
    {
        if ($graph) {
            $this->graph = $graph;
            $this->setUp();
        }

        if ($loggerMessage) {
            $this->loggerProphecy->warning($loggerMessage)->shouldBeCalled();
        }

        $this->assertEquals($expectedClass, ($this->classPropertiesAppender)($class));
    }

    /**
     * @return \Generator<array{0: Class_, 1: Class_, 2?: ?RdfGraph, 3?: string}>
     */
    public function provideInvokeTestCases(): \Generator
    {
        $product = new Class_('Product', new RdfResource('https://schema.org/Product'));
        yield 'no configuration no properties in map' => [clone $product, clone $product, null, 'Properties for "https://schema.org/Product" not found in the map.'];

        $article = new Class_('Article', new RdfResource('https://schema.org/Article'));
        $graph = new RdfGraph();
        $expectedArticleBodyProperty = new Property('articleBody');
        $expectedArticleBodyProperty->cardinality = CardinalitiesExtractor::CARDINALITY_1_1;
        $expectedArticleBodyProperty->resource = new RdfResource('https://schema.org/articleBody', $graph);
        $expectedArticleBodyProperty->range = new RdfResource('https://schema.org/Text', $graph);
        $expectedArticleBodyProperty->rangeName = 'Text';
        $expectedArticleBodyProperty->isNullable = false;
        $expectedArticleSectionProperty = new Property('articleSection');
        $expectedArticleSectionProperty->cardinality = CardinalitiesExtractor::CARDINALITY_1_1;
        $expectedArticleSectionProperty->resource = new RdfResource('https://schema.org/articleSection', $graph);
        $expectedArticleSectionProperty->range = new RdfResource('https://schema.org/Text', $graph);
        $expectedArticleSectionProperty->rangeName = 'Text';
        $expectedArticleSectionProperty->isNullable = false;
        yield 'no configuration' => [clone $article, (clone $article)->addProperty($expectedArticleBodyProperty)->addProperty($expectedArticleSectionProperty), $graph];

        $graph = new RdfGraph();
        $person = new Class_('Person', new RdfResource('https://schema.org/Person', $graph));
        $expectedGivenNameProperty = new Property('givenName');
        $expectedGivenNameProperty->cardinality = CardinalitiesExtractor::CARDINALITY_1_1;
        $expectedGivenNameProperty->resource = new RdfResource('https://schema.org/givenName', $graph);
        $expectedGivenNameProperty->range = new RdfResource('https://schema.org/Text', $graph);
        $expectedGivenNameProperty->rangeName = 'Text';
        $expectedGivenNameProperty->isNullable = true;
        $expectedGivenNameProperty->ormColumn = [];
        yield 'with configuration' => [clone $person, (clone $person)->addProperty($expectedGivenNameProperty), $graph];
    }
}
