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
use ApiPlatform\SchemaGenerator\FilesGenerator;
use ApiPlatform\SchemaGenerator\GoodRelationsBridge;
use ApiPlatform\SchemaGenerator\PhpTypeConverter;
use ApiPlatform\SchemaGenerator\Printer;
use ApiPlatform\SchemaGenerator\SchemaGeneratorConfiguration;
use ApiPlatform\SchemaGenerator\TypesGenerator;
use EasyRdf\Graph as RdfGraph;
use EasyRdf\RdfNamespace;
use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;
use Symfony\Component\Config\Definition\Processor;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\NullOutput;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\String\Inflector\EnglishInflector;
use Twig\Environment;

/**
 * @author Teoh Han Hui <teohhanhui@gmail.com>
 */
class TypesGeneratorTest extends TestCase
{
    use ProphecyTrait;

    protected function setUp(): void
    {
        RdfNamespace::set('schema', 'https://schema.org/');
    }

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

        $inflector = new EnglishInflector();

        $typesGenerator = new TypesGenerator(
            $inflector,
            $this->getGraphs(),
            new PhpTypeConverter(),
            $cardinalitiesExtractor,
            $goodRelationsBridge
        );

        $filesGenerator = new FilesGenerator(
            $inflector,
            new Printer(),
            $twig,
            new SymfonyStyle(new ArrayInput([]), new NullOutput())
        );

        $outputDir = 'build/type-generator-test';
        $configuration = new SchemaGeneratorConfiguration();
        /** @var Configuration $processedConfiguration */
        $processedConfiguration = (new Processor())->processConfiguration($configuration, [$this->getConfig()]);
        $processedConfiguration['output'] = $outputDir;
        $classes = $typesGenerator->generate($processedConfiguration);
        $filesGenerator->generate($classes, $processedConfiguration);

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

    /**
     * @return RdfGraph[]
     */
    private function getGraphs(): array
    {
        $graph = new RdfGraph();

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

    /**
     * @return array<string, string>
     */
    private function getCardinalities(): array
    {
        return [
            'https://schema.org/articleBody' => CardinalitiesExtractor::CARDINALITY_0_1,
            'https://schema.org/articleSection' => CardinalitiesExtractor::CARDINALITY_0_N,
            'https://schema.org/author' => CardinalitiesExtractor::CARDINALITY_0_1,
            'https://schema.org/datePublished' => CardinalitiesExtractor::CARDINALITY_UNKNOWN,
            'https://schema.org/headline' => CardinalitiesExtractor::CARDINALITY_UNKNOWN,
            'https://schema.org/isFamilyFriendly' => CardinalitiesExtractor::CARDINALITY_0_1,
            'https://schema.org/name' => CardinalitiesExtractor::CARDINALITY_0_1,
            'https://schema.org/sharedContent' => CardinalitiesExtractor::CARDINALITY_UNKNOWN,
        ];
    }

    /**
     * @return array{
     *     annotationGenerators: string[],
     *     attributeGenerators: string[],
     *     types: array<string, array{
     *         allProperties?: boolean,
     *         properties?: ?array<string, array{
     *             cardinality: string,
     *             range: string
     *         }>
     *     }>
     * }
     */
    private function getConfig(): array
    {
        return [
            'annotationGenerators' => [
            ],
            'attributeGenerators' => [
            ],
            'types' => [
                'Article' => [
                    'parent' => null,
                    'properties' => [
                        'articleBody' => null,
                        'articleSection' => null,
                    ],
                ],
                'CreativeWork' => [
                    'parent' => null,
                    'properties' => [
                        'author' => [
                            'cardinality' => CardinalitiesExtractor::CARDINALITY_N_0,
                            'range' => 'Person',
                        ],
                        'datePublished' => null,
                        'headline' => null,
                        'isFamilyFriendly' => null,
                    ],
                ],
                'BlogPosting' => [
                    'parent' => null,
                    'allProperties' => true,
                    'properties' => null,
                ],
                'Person' => [
                    'parent' => null,
                    'properties' => [],
                ],
                'SocialMediaPosting' => [
                    'parent' => null,
                    'allProperties' => true,
                ],
                'Thing' => [
                    'parent' => null,
                    'allProperties' => true,
                ],
            ],
        ];
    }
}
