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
use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;
use Symfony\Component\Config\Definition\Processor;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\NullOutput;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;
use Symfony\Component\String\Inflector\EnglishInflector;
use Twig\Environment;

/**
 * @author Teoh Han Hui <teohhanhui@gmail.com>
 *
 * @phpstan-type Config array{
 *     vocabularies?: array{uri: string, format: ?string, allTypes?: boolean}[],
 *     annotationGenerators: string[],
 *     attributeGenerators: string[],
 *     types?: array<string, array{
 *         allProperties?: boolean,
 *         properties?: ?array<string, ?array{
 *             cardinality: string,
 *             range: string
 *         }>,
 *         parent?: ?string
 *     }>,
 *     allTypes?: boolean,
 *     resolveTypes?: boolean
 * }
 */
class TypesGeneratorTest extends TestCase
{
    use ProphecyTrait;

    private string $outputDir = 'build/type-generator-test';
    private TypesGenerator $typesGenerator;
    private FilesGenerator $filesGenerator;

    protected function setUp(): void
    {
        RdfNamespace::set('schema', 'https://schema.org/');

        $twigProphecy = $this->prophesize(Environment::class);
        $twig = $twigProphecy->reveal();

        $cardinalitiesExtractorProphecy = $this->prophesize(CardinalitiesExtractor::class);
        $cardinalities = $this->getCardinalities();
        $cardinalitiesExtractorProphecy->extract(Argument::type('array'))->willReturn($cardinalities);
        $cardinalitiesExtractor = $cardinalitiesExtractorProphecy->reveal();

        $goodRelationsBridgeProphecy = $this->prophesize(GoodRelationsBridge::class);
        $goodRelationsBridge = $goodRelationsBridgeProphecy->reveal();

        $inflector = new EnglishInflector();

        $this->typesGenerator = new TypesGenerator(
            $inflector,
            new PhpTypeConverter(),
            $cardinalitiesExtractor,
            $goodRelationsBridge
        );

        $this->filesGenerator = new FilesGenerator(
            $inflector,
            new Printer(),
            $twig,
            new SymfonyStyle(new ArrayInput([]), new NullOutput())
        );
    }

    public function testGenerate(): void
    {
        $this->generateForConfiguration($this->getConfig(), $this->getGraphs());

        $finder = new Finder();
        self::assertSame(6, $finder->files()->in($this->outputDir)->count());

        $article = file_get_contents("$this->outputDir/App/Entity/Article.php");
        $this->assertStringContainsString('abstract class Article extends CreativeWork', $article);
        $this->assertStringContainsString('private ?string $articleBody = null;', $article);
        $this->assertStringContainsString('private array $articleSection = [];', $article);
        $this->assertStringContainsString('public function setArticleBody(?string $articleBody): void', $article);
        $this->assertStringContainsString('public function getArticleBody(): ?string', $article);
        $this->assertStringContainsString('public function addArticleSection(string $articleSection): void', $article);
        $this->assertStringContainsString('public function removeArticleSection(string $articleSection): void', $article);

        $creativeWork = file_get_contents("$this->outputDir/App/Entity/CreativeWork.php");
        $this->assertStringContainsString('class CreativeWork extends Thing', $creativeWork);
        $this->assertStringContainsString('private ?Person $author = null;', $creativeWork);
        $this->assertStringContainsString('private ?\DateTimeInterface $datePublished = null;', $creativeWork);
        $this->assertStringContainsString('private ?string $headline = null;', $creativeWork);
        $this->assertStringContainsString('private ?bool $isFamilyFriendly = null;', $creativeWork);

        $blogPosting = file_get_contents("$this->outputDir/App/Entity/BlogPosting.php");
        $this->assertStringContainsString('class BlogPosting extends SocialMediaPosting', $blogPosting);

        $socialMediaPosting = file_get_contents("$this->outputDir/App/Entity/SocialMediaPosting.php");
        $this->assertStringContainsString('abstract class SocialMediaPosting extends Article', $socialMediaPosting);
        $this->assertStringContainsString('private CreativeWork $sharedContent;', $socialMediaPosting);
        $this->assertStringContainsString(<<<'PHP'
    public function setSharedContent(CreativeWork $sharedContent): void
    {
        $this->sharedContent = $sharedContent;
    }
PHP, $socialMediaPosting);

        $this->assertStringContainsString(<<<'PHP'
    public function getSharedContent(): CreativeWork
    {
        return $this->sharedContent;
    }
PHP, $socialMediaPosting);

        $person = file_get_contents("$this->outputDir/App/Entity/Person.php");
        $this->assertStringContainsString('class Person extends Thing', $person);

        $thing = file_get_contents("$this->outputDir/App/Entity/Thing.php");
        $this->assertStringContainsString(<<<'PHP'
abstract class Thing
{
    private ?int $id = null;
    private ?string $name = null;

    public function getId(): ?int
    {
        return $this->id;
    }

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

    public function testGenerateAllResolveTypes(): void
    {
        $this->generateForConfiguration($this->getAllResolveTypesConfig(), $this->getGraphs());

        $finder = new Finder();
        self::assertSame(2, $finder->files()->in($this->outputDir)->count());

        $competencyWorldEntity = file_get_contents("$this->outputDir/App/Entity/CompetencyWorldEntity.php");
        $this->assertStringContainsString('class CompetencyWorldEntity extends Thing', $competencyWorldEntity);
        $this->assertStringContainsString('private ?string $hasAppellation = null;', $competencyWorldEntity);
        $this->assertStringContainsString('private ?string $hasDescription = null;', $competencyWorldEntity);
        $this->assertStringContainsString('private array $intendedOccupation = [];', $competencyWorldEntity);
        $this->assertStringContainsString('public function setHasAppellation(?string $hasAppellation): void', $competencyWorldEntity);
        $this->assertStringContainsString('public function getHasAppellation(): ?string', $competencyWorldEntity);
    }

    public function testGenerateVocabAllTypes(): void
    {
        $this->generateForConfiguration($this->getVocabAllTypesConfig(), $this->getGraphs());

        $finder = new Finder();
        self::assertSame(2, $finder->files()->in($this->outputDir)->count());
    }

    public function testGenerateMissingParent(): void
    {
        $loggerProphecy = $this->prophesize(LoggerInterface::class);
        $loggerProphecy->error('The type "CreativeWork" (parent of "https://schema.org/Article") doesn\'t exist')->shouldBeCalled();
        $this->typesGenerator->setLogger($loggerProphecy->reveal());

        $this->generateForConfiguration($this->getMissingParentConfig(), $this->getGraphs());

        $finder = new Finder();
        self::assertSame(1, $finder->files()->in($this->outputDir)->count());

        $this->typesGenerator->setLogger(new NullLogger());
    }

    /**
     * @param Config $config
     */
    private function generateForConfiguration(array $config, array $graphs): void
    {
        $finder = new Finder();

        $filesystem = new Filesystem();
        if ($filesystem->exists($this->outputDir)) {
            $filesystem->remove($finder->files()->in($this->outputDir));
        }

        $configuration = new SchemaGeneratorConfiguration();
        /** @var Configuration $processedConfiguration */
        $processedConfiguration = (new Processor())->processConfiguration($configuration, [$config]);
        $processedConfiguration['output'] = $this->outputDir;
        $classes = $this->typesGenerator->generate($graphs, $processedConfiguration);
        $this->filesGenerator->generate($classes, $processedConfiguration);
    }

    /**
     * @return RdfGraph[]
     */
    private function getGraphs(): array
    {
        $nodeGraph = new RdfGraph('nodefr-2.jsonld');

        $nodeGraph->addResource('https://gitlab.com/mmorg/nodefr-2/CompetencyWorldEntity', 'rdf:type', 'rdfs:Class');
        $nodeGraph->addResource('https://gitlab.com/mmorg/nodefr-2/CompetencyWorldEntity', 'rdfs:subClassOf', 'https://schema.org/Thing');

        $nodeGraph->addResource('_:b0_n0', 'rdf:type', 'rdfs:Class');

        $nodeGraph->addResource('https://gitlab.com/mmorg/nodefr-2/hasAppellation', 'rdf:type', 'rdf:Property');
        $nodeGraph->addResource('https://gitlab.com/mmorg/nodefr-2/hasAppellation', 'schema:domainIncludes', 'https://gitlab.com/mmorg/nodefr-2/CompetencyWorldEntity');
        $nodeGraph->addResource('https://gitlab.com/mmorg/nodefr-2/hasAppellation', 'schema:rangeIncludes', 'http://www.w3.org/1999/02/22-rdf-syntax-ns#langString');
        $nodeGraph->addResource('https://gitlab.com/mmorg/nodefr-2/hasAppellation', 'schema:rangeIncludes', 'https://schema.org/Text');

        $nodeGraph->addResource('https://gitlab.com/mmorg/nodefr-2/hasDescription', 'rdf:type', 'rdf:Property');
        $nodeGraph->addResource('https://gitlab.com/mmorg/nodefr-2/hasDescription', 'schema:domainIncludes', 'https://gitlab.com/mmorg/nodefr-2/CompetencyWorldEntity');
        $nodeGraph->addResource('https://gitlab.com/mmorg/nodefr-2/hasDescription', 'schema:rangeIncludes', 'https://gitlab.com/mmorg/nodefr-2/n3-5');

        $nodeGraph->addResource('https://gitlab.com/mmorg/nodefr-2/n3-5', 'rdf:type', 'rdfs:Class');
        $nodeGraph->addResource('https://gitlab.com/mmorg/nodefr-2/n3-5', 'owl:unionOf', 'https://gitlab.com/mmorg/nodefr-2/n3-6');

        $nodeGraph->addResource('https://gitlab.com/mmorg/nodefr-2/n3-6', 'rdf:first', 'http://www.w3.org/2001/XMLSchema#language');
        $nodeGraph->addResource('https://gitlab.com/mmorg/nodefr-2/n3-6', 'rdf:rest', 'https://gitlab.com/mmorg/nodefr-2/n3-7');

        $nodeGraph->addResource('https://gitlab.com/mmorg/nodefr-2/n3-7', 'rdf:first', 'http://www.w3.org/2001/XMLSchema#string');
        $nodeGraph->addResource('https://gitlab.com/mmorg/nodefr-2/n3-7', 'rdf:rest', 'http://www.w3.org/1999/02/22-rdf-syntax-ns#langString');

        $nodeGraph->addResource('https://gitlab.com/mmorg/nodefr-2/intendedOccupation', 'rdf:type', 'rdf:Property');
        $nodeGraph->addResource('https://gitlab.com/mmorg/nodefr-2/intendedOccupation', 'schema:domainIncludes', 'https://gitlab.com/mmorg/nodefr-2/CompetencyWorldEntity');
        $nodeGraph->addResource('https://gitlab.com/mmorg/nodefr-2/intendedOccupation', 'schema:rangeIncludes', 'https://gitlab.com/mmorg/nodefr-2/specialCase');

        $graph = new RdfGraph(SchemaGeneratorConfiguration::SCHEMA_ORG_URI);

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

        return [$nodeGraph, $graph];
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
     * @return Config
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

    /**
     * @return Config
     */
    private function getMissingParentConfig(): array
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
            ],
        ];
    }

    /**
     * @return Config
     */
    private function getAllResolveTypesConfig(): array
    {
        return [
            'vocabularies' => [
                ['uri' => SchemaGeneratorConfiguration::SCHEMA_ORG_URI, 'format' => null, 'allTypes' => false],
                ['uri' => 'nodefr-2.jsonld', 'format' => 'jsonld'],
            ],
            'annotationGenerators' => [
            ],
            'attributeGenerators' => [
            ],
            'relations' => ['defaultCardinality' => '(1..*)'],
            'allTypes' => true,
            'resolveTypes' => true,
        ];
    }

    /**
     * @return Config
     */
    private function getVocabAllTypesConfig(): array
    {
        return [
            'vocabularies' => [
                ['uri' => SchemaGeneratorConfiguration::SCHEMA_ORG_URI, 'format' => null, 'allTypes' => false],
                ['uri' => 'nodefr-2.jsonld', 'format' => 'jsonld', 'allTypes' => true],
            ],
            'annotationGenerators' => [
            ],
            'attributeGenerators' => [
            ],
            'types' => [
                'BlogPosting' => [
                    'parent' => null,
                    'allProperties' => true,
                    'properties' => null,
                ],
            ],
        ];
    }
}
