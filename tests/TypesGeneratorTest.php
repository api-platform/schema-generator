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

namespace ApiPlatform\SchemaGenerator\Tests;

use ApiPlatform\SchemaGenerator\CardinalitiesExtractor;
use ApiPlatform\SchemaGenerator\GoodRelationsBridge;
use ApiPlatform\SchemaGenerator\PhpTypeConverter;
use ApiPlatform\SchemaGenerator\Printer;
use ApiPlatform\SchemaGenerator\TypesGenerator;
use ApiPlatform\SchemaGenerator\TypesGeneratorConfiguration;
use Doctrine\Inflector\InflectorFactory;
use EasyRdf\Graph;
use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;
use Psr\Log\NullLogger;
use Twig\Environment;

/**
 * @author Teoh Han Hui <teohhanhui@gmail.com>
 */
class TypesGeneratorTest extends TestCase
{
    use ProphecyTrait;

    public function testGenerate(): void
    {
        $twigProphecy = $this->prophesize(Environment::class);
        $twig = $twigProphecy->reveal();

        $cardinalitiesExtractorProphecy = $this->prophesize(CardinalitiesExtractor::class);
        $cardinalities = $this->getCardinalities();
        $cardinalitiesExtractorProphecy->extract()->willReturn($cardinalities)->shouldBeCalled();
        $cardinalitiesExtractor = $cardinalitiesExtractorProphecy->reveal();

        $goodRelationsBridgeProphecy = $this->prophesize(GoodRelationsBridge::class);
        $goodRelationsBridge = $goodRelationsBridgeProphecy->reveal();

        $typesGenerator = new TypesGenerator(
            InflectorFactory::create()->build(),
            $twig,
            new NullLogger(),
            $this->getGraphs(),
            new PhpTypeConverter(),
            $cardinalitiesExtractor,
            $goodRelationsBridge,
            new Printer()
        );

        $outputDir = 'build/type-generator-test';
        $typesGenerator->generate($this->getConfig($outputDir));

        $article = file_get_contents("$outputDir/App/Entity/Article.php");
        $this->assertStringContainsString('abstract class Article extends CreativeWork', $article);
        $this->assertStringContainsString('private ?string $articleBody = null;', $article);
        $this->assertStringContainsString('private array $articleSection = [];', $article);
        $this->assertStringContainsString('public function setArticleBody(?string $articleBody): void', $article);
        $this->assertStringContainsString('public function getArticleBody(): ?string', $article);
        $this->assertStringContainsString('public function addArticleSection(string $articleSection): void', $article);
        $this->assertStringContainsString('public function removeArticleSection(string $articleSection): void', $article);

        $creativeWork = file_get_contents("$outputDir/App/Entity/CreativeWork.php");
        $this->assertStringContainsString('abstract class CreativeWork extends Thing', $creativeWork);
        $this->assertStringContainsString('private ?Person $author = null;', $creativeWork);
        $this->assertStringContainsString('private ?\DateTimeInterface $datePublished = null;', $creativeWork);
        $this->assertStringContainsString('private ?string $headline = null;', $creativeWork);
        $this->assertStringContainsString('private ?bool $isFamilyFriendly = null;', $creativeWork);

        $blogPosting = file_get_contents("$outputDir/App/Entity/BlogPosting.php");
        $this->assertStringContainsString('class BlogPosting extends SocialMediaPosting', $blogPosting);
        $this->assertStringContainsString('private ?int $id = null;', $blogPosting);
        $this->assertStringContainsString('public function getId(): ?int', $blogPosting);

        $socialMediaPosting = file_get_contents("$outputDir/App/Entity/SocialMediaPosting.php");
        $this->assertStringContainsString('abstract class SocialMediaPosting extends Article', $socialMediaPosting);
        $this->assertStringContainsString('private ?CreativeWork $sharedContent = null;', $socialMediaPosting);
        $this->assertStringContainsString(<<<'PHP'
    public function setSharedContent(?CreativeWork $sharedContent): void
    {
        $this->sharedContent = $sharedContent;
    }
PHP, $socialMediaPosting);

        $this->assertStringContainsString(<<<'PHP'
    public function getSharedContent(): ?CreativeWork
    {
        return $this->sharedContent;
    }
PHP, $socialMediaPosting);

        $person = file_get_contents("$outputDir/App/Entity/Person.php");
        $this->assertStringContainsString('class Person extends Thing', $person);
        $this->assertStringContainsString('private ?int $id = null;', $person);
        $this->assertStringContainsString('public function getId(): ?int', $person);

        $thing = file_get_contents("$outputDir/App/Entity/Thing.php");
        $this->assertStringContainsString(<<<'PHP'
abstract class Thing
{
    private ?string $name = null;

    public function setName(?string $name): void
    {
        $this->name = $name;
    }

    public function getName(): ?string
    {
        return $this->name;
    }
}
PHP, $thing);
    }

    private function getGraphs(): array
    {
        $graph = new Graph();

        $graph->addResource('https://schema.org/Article', 'rdf:type', 'rdfs:Class');
        $graph->addResource('https://schema.org/Article', 'rdfs:subClassOf', 'https://schema.org/CreativeWork');

        $graph->addResource('https://schema.org/BlogPosting', 'rdf:type', 'rdfs:Class');
        $graph->addResource('https://schema.org/BlogPosting', 'rdfs:subClassOf', 'https://schema.org/SocialMediaPosting');

        $graph->addResource('https://schema.org/CreativeWork', 'rdf:type', 'rdfs:Class');
        $graph->addResource('https://schema.org/CreativeWork', 'rdfs:subClassOf', 'https://schema.org/Thing');

        $graph->addResource('https://schema.org/Person', 'rdf:type', 'rdfs:Class');
        $graph->addResource('https://schema.org/Person', 'rdfs:subClassOf', 'https://schema.org/Thing');

        $graph->addResource('https://schema.org/SocialMediaPosting', 'rdf:type', 'rdfs:Class');
        $graph->addResource('https://schema.org/SocialMediaPosting', 'rdfs:subClassOf', 'https://schema.org/Article');

        $graph->addResource('https://schema.org/Thing', 'rdf:type', 'rdfs:Class');

        $graph->addResource('https://schema.org/articleBody', 'rdf:type', 'rdf:Property');
        $graph->addResource('https://schema.org/articleBody', 'schema:domainIncludes', 'https://schema.org/Article');
        $graph->addResource('https://schema.org/articleBody', 'schema:rangeIncludes', 'https://schema.org/Text');

        $graph->addResource('https://schema.org/articleSection', 'rdf:type', 'rdf:Property');
        $graph->addResource('https://schema.org/articleSection', 'schema:domainIncludes', 'https://schema.org/Article');
        $graph->addResource('https://schema.org/articleSection', 'schema:rangeIncludes', 'https://schema.org/Text');

        $graph->addResource('https://schema.org/author', 'rdf:type', 'rdf:Property');
        $graph->addResource('https://schema.org/author', 'schema:domainIncludes', 'https://schema.org/CreativeWork');
        $graph->addResource('https://schema.org/author', 'schema:rangeIncludes', 'https://schema.org/Person');

        $graph->addResource('https://schema.org/datePublished', 'rdf:type', 'rdf:Property');
        $graph->addResource('https://schema.org/datePublished', 'schema:domainIncludes', 'https://schema.org/CreativeWork');
        $graph->addResource('https://schema.org/datePublished', 'schema:rangeIncludes', 'https://schema.org/Date');

        $graph->addResource('https://schema.org/headline', 'rdf:type', 'rdf:Property');
        $graph->addResource('https://schema.org/headline', 'schema:domainIncludes', 'https://schema.org/CreativeWork');
        $graph->addResource('https://schema.org/headline', 'schema:rangeIncludes', 'https://schema.org/Text');

        $graph->addResource('https://schema.org/isFamilyFriendly', 'rdf:type', 'rdf:Property');
        $graph->addResource('https://schema.org/isFamilyFriendly', 'schema:domainIncludes', 'https://schema.org/CreativeWork');
        $graph->addResource('https://schema.org/isFamilyFriendly', 'schema:rangeIncludes', 'https://schema.org/Boolean');

        $graph->addResource('https://schema.org/name', 'rdf:type', 'rdf:Property');
        $graph->addResource('https://schema.org/name', 'schema:domainIncludes', 'https://schema.org/Thing');
        $graph->addResource('https://schema.org/name', 'schema:rangeIncludes', 'https://schema.org/Text');

        $graph->addResource('https://schema.org/sharedContent', 'rdf:type', 'rdf:Property');
        $graph->addResource('https://schema.org/sharedContent', 'schema:domainIncludes', 'https://schema.org/SocialMediaPosting');
        $graph->addResource('https://schema.org/sharedContent', 'schema:rangeIncludes', 'https://schema.org/CreativeWork');

        return [$graph];
    }

    private function getCardinalities(): array
    {
        return [
            'http://schema.org/articleBody' => CardinalitiesExtractor::CARDINALITY_0_1,
            'http://schema.org/articleSection' => CardinalitiesExtractor::CARDINALITY_0_N,
            'http://schema.org/author' => CardinalitiesExtractor::CARDINALITY_0_1,
            'http://schema.org/datePublished' => CardinalitiesExtractor::CARDINALITY_UNKNOWN,
            'http://schema.org/headline' => CardinalitiesExtractor::CARDINALITY_UNKNOWN,
            'http://schema.org/isFamilyFriendly' => CardinalitiesExtractor::CARDINALITY_0_1,
            'http://schema.org/name' => CardinalitiesExtractor::CARDINALITY_0_1,
            'http://schema.org/sharedContent' => CardinalitiesExtractor::CARDINALITY_UNKNOWN,
        ];
    }

    private function getConfig(string $outputDir): array
    {
        return [
            'annotationGenerators' => [
            ],
            'checkIsGoodRelations' => false,
            'namespaces' => [
                'entity' => 'App\Entity',
            ],
            'output' => $outputDir,
            'allTypes' => false,
            'types' => [
                'Article' => [
                    'allProperties' => false,
                    'properties' => [
                        'articleBody' => null,
                        'articleSection' => null,
                    ],
                    'vocabularyNamespace' => TypesGeneratorConfiguration::SCHEMA_ORG_NAMESPACE,
                ],
                'CreativeWork' => [
                    'allProperties' => false,
                    'properties' => [
                        'author' => [
                            'cardinality' => CardinalitiesExtractor::CARDINALITY_N_0,
                            'range' => 'Person',
                        ],
                        'datePublished' => null,
                        'headline' => null,
                        'isFamilyFriendly' => null,
                    ],
                    'vocabularyNamespace' => TypesGeneratorConfiguration::SCHEMA_ORG_NAMESPACE,
                ],
                'BlogPosting' => [
                    'allProperties' => true,
                    'properties' => null,
                    'vocabularyNamespace' => TypesGeneratorConfiguration::SCHEMA_ORG_NAMESPACE,
                ],
                'Person' => [
                    'allProperties' => false,
                    'properties' => [],
                    'vocabularyNamespace' => TypesGeneratorConfiguration::SCHEMA_ORG_NAMESPACE,
                ],
                'SocialMediaPosting' => [
                    'allProperties' => true,
                    'vocabularyNamespace' => TypesGeneratorConfiguration::SCHEMA_ORG_NAMESPACE,
                ],
                'Thing' => [
                    'allProperties' => true,
                    'vocabularyNamespace' => TypesGeneratorConfiguration::SCHEMA_ORG_NAMESPACE,
                ],
            ],
            'id' => [
                'generate' => true,
                'generationStrategy' => 'auto',
                'writable' => false,
                'onClass' => 'child',
            ],
            'useInterface' => false,
            'doctrine' => [
                'useCollection' => true,
                'resolveTargetEntityConfigPath' => null,
            ],
        ];
    }
}
