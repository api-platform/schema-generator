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
use ApiPlatform\SchemaGenerator\TypesGenerator;
use ApiPlatform\SchemaGenerator\TypesGeneratorConfiguration;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Psr\Log\NullLogger;
use Twig\Environment;

/**
 * @author Teoh Han Hui <teohhanhui@gmail.com>
 */
class TypesGeneratorTest extends TestCase
{
    public function testGenerate(): void
    {
        $twigProphecy = $this->prophesize(Environment::class);
        foreach ($this->getClasses() as $class) {
            $twigProphecy->render('class.php.twig', Argument::that($this->getContextMatcher($class)))->willReturn('')->shouldBeCalled();
        }
        $twigProphecy->render('class.php.twig', Argument::type('array'))->willReturn('');
        $twig = $twigProphecy->reveal();

        $cardinalitiesExtractorProphecy = $this->prophesize(CardinalitiesExtractor::class);
        $cardinalities = $this->getCardinalities();
        $cardinalitiesExtractorProphecy->extract()->willReturn($cardinalities)->shouldBeCalled();
        $cardinalitiesExtractor = $cardinalitiesExtractorProphecy->reveal();

        $goodRelationsBridgeProphecy = $this->prophesize(GoodRelationsBridge::class);
        $goodRelationsBridge = $goodRelationsBridgeProphecy->reveal();

        $typesGenerator = new TypesGenerator($twig, new NullLogger(), $this->getGraphs(), $cardinalitiesExtractor, $goodRelationsBridge);

        $typesGenerator->generate($this->getConfig());
    }

    private function getGraphs(): array
    {
        $graph = new \EasyRdf_Graph();

        $graph->addResource('http://schema.org/Article', 'rdf:type', 'rdfs:Class');
        $graph->addResource('http://schema.org/Article', 'rdfs:subClassOf', 'http://schema.org/CreativeWork');

        $graph->addResource('http://schema.org/BlogPosting', 'rdf:type', 'rdfs:Class');
        $graph->addResource('http://schema.org/BlogPosting', 'rdfs:subClassOf', 'http://schema.org/SocialMediaPosting');

        $graph->addResource('http://schema.org/CreativeWork', 'rdf:type', 'rdfs:Class');
        $graph->addResource('http://schema.org/CreativeWork', 'rdfs:subClassOf', 'http://schema.org/Thing');

        $graph->addResource('http://schema.org/Person', 'rdf:type', 'rdfs:Class');
        $graph->addResource('http://schema.org/Person', 'rdfs:subClassOf', 'http://schema.org/Thing');

        $graph->addResource('http://schema.org/SocialMediaPosting', 'rdf:type', 'rdfs:Class');
        $graph->addResource('http://schema.org/SocialMediaPosting', 'rdfs:subClassOf', 'http://schema.org/Article');

        $graph->addResource('http://schema.org/Thing', 'rdf:type', 'rdfs:Class');

        $graph->addResource('http://schema.org/articleBody', 'rdf:type', 'rdf:Property');
        $graph->addResource('http://schema.org/articleBody', 'schema:domainIncludes', 'http://schema.org/Article');
        $graph->addResource('http://schema.org/articleBody', 'schema:rangeIncludes', 'http://schema.org/Text');

        $graph->addResource('http://schema.org/articleSection', 'rdf:type', 'rdf:Property');
        $graph->addResource('http://schema.org/articleSection', 'schema:domainIncludes', 'http://schema.org/Article');
        $graph->addResource('http://schema.org/articleSection', 'schema:rangeIncludes', 'http://schema.org/Text');

        $graph->addResource('http://schema.org/author', 'rdf:type', 'rdf:Property');
        $graph->addResource('http://schema.org/author', 'schema:domainIncludes', 'http://schema.org/CreativeWork');
        $graph->addResource('http://schema.org/author', 'schema:rangeIncludes', 'http://schema.org/Person');

        $graph->addResource('http://schema.org/datePublished', 'rdf:type', 'rdf:Property');
        $graph->addResource('http://schema.org/datePublished', 'schema:domainIncludes', 'http://schema.org/CreativeWork');
        $graph->addResource('http://schema.org/datePublished', 'schema:rangeIncludes', 'http://schema.org/Date');

        $graph->addResource('http://schema.org/headline', 'rdf:type', 'rdf:Property');
        $graph->addResource('http://schema.org/headline', 'schema:domainIncludes', 'http://schema.org/CreativeWork');
        $graph->addResource('http://schema.org/headline', 'schema:rangeIncludes', 'http://schema.org/Text');

        $graph->addResource('http://schema.org/isFamilyFriendly', 'rdf:type', 'rdf:Property');
        $graph->addResource('http://schema.org/isFamilyFriendly', 'schema:domainIncludes', 'http://schema.org/CreativeWork');
        $graph->addResource('http://schema.org/isFamilyFriendly', 'schema:rangeIncludes', 'http://schema.org/Boolean');

        $graph->addResource('http://schema.org/name', 'rdf:type', 'rdf:Property');
        $graph->addResource('http://schema.org/name', 'schema:domainIncludes', 'http://schema.org/Thing');
        $graph->addResource('http://schema.org/name', 'schema:rangeIncludes', 'http://schema.org/Text');

        $graph->addResource('http://schema.org/sharedContent', 'rdf:type', 'rdf:Property');
        $graph->addResource('http://schema.org/sharedContent', 'schema:domainIncludes', 'http://schema.org/SocialMediaPosting');
        $graph->addResource('http://schema.org/sharedContent', 'schema:rangeIncludes', 'http://schema.org/CreativeWork');

        return [$graph];
    }

    private function getCardinalities(): array
    {
        return [
            'articleBody' => CardinalitiesExtractor::CARDINALITY_0_1,
            'articleSection' => CardinalitiesExtractor::CARDINALITY_0_N,
            'author' => CardinalitiesExtractor::CARDINALITY_0_1,
            'datePublished' => CardinalitiesExtractor::CARDINALITY_UNKNOWN,
            'headline' => CardinalitiesExtractor::CARDINALITY_UNKNOWN,
            'isFamilyFriendly' => CardinalitiesExtractor::CARDINALITY_0_1,
            'name' => CardinalitiesExtractor::CARDINALITY_0_1,
            'sharedContent' => CardinalitiesExtractor::CARDINALITY_UNKNOWN,
        ];
    }

    private function getConfig(): array
    {
        return [
            'annotationGenerators' => [
            ],
            'checkIsGoodRelations' => false,
            'namespaces' => [
                'entity' => 'AppBundle\Entity',
            ],
            'output' => 'build/type-generator-test',
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
            ],
            'useInterface' => false,
            'doctrine' => [
                'useCollection' => true,
                'resolveTargetEntityConfigPath' => null,
            ],
        ];
    }

    private function getClasses(): array
    {
        return [
            'Article' => [
                'abstract' => true,
                'embeddable' => false,
                'fields' => [
                    'articleBody' => [
                        'cardinality' => CardinalitiesExtractor::CARDINALITY_0_1,
                        'isArray' => false,
                        'isCustom' => false,
                        'isEnum' => false,
                        'isId' => false,
                        'isReadable' => true,
                        'isWritable' => true,
                        'isNullable' => true,
                        'isUnique' => false,
                        'name' => 'articleBody',
                        'range' => 'Text',
                    ],
                    'articleSection' => [
                        'cardinality' => CardinalitiesExtractor::CARDINALITY_0_N,
                        'isArray' => false,
                        'isCustom' => false,
                        'isEnum' => false,
                        'isId' => false,
                        'isReadable' => true,
                        'isWritable' => true,
                        'isNullable' => true,
                        'isUnique' => false,
                        'name' => 'articleSection',
                        'range' => 'Text',
                    ],
                ],
                'hasChild' => true,
                'isEnum' => false,
                'name' => 'Article',
                'namespace' => 'AppBundle\Entity',
                'parent' => 'CreativeWork',
            ],
            'BlogPosting' => [
                'abstract' => false,
                'embeddable' => false,
                'fields' => [
                    'id' => [
                        'cardinality' => CardinalitiesExtractor::CARDINALITY_1_1,
                        'isArray' => false,
                        'isCustom' => true,
                        'isEnum' => false,
                        'isId' => true,
                        'isReadable' => true,
                        'isWritable' => true,
                        'isNullable' => false,
                        'isUnique' => false,
                        'name' => 'id',
                        'range' => 'Integer',
                    ],
                ],
                'hasChild' => false,
                'isEnum' => false,
                'name' => 'BlogPosting',
                'namespace' => 'AppBundle\Entity',
                'parent' => 'SocialMediaPosting',
            ],
            'CreativeWork' => [
                'abstract' => true,
                'embeddable' => false,
                'fields' => [
                    'author' => [
                        'cardinality' => CardinalitiesExtractor::CARDINALITY_N_0,
                        'isArray' => false,
                        'isCustom' => false,
                        'isEnum' => false,
                        'isId' => false,
                        'isReadable' => true,
                        'isWritable' => true,
                        'isNullable' => true,
                        'isUnique' => false,
                        'name' => 'author',
                        'range' => 'Person',
                    ],
                    'datePublished' => [
                        'cardinality' => CardinalitiesExtractor::CARDINALITY_UNKNOWN,
                        'isArray' => false,
                        'isCustom' => false,
                        'isEnum' => false,
                        'isId' => false,
                        'isReadable' => true,
                        'isWritable' => true,
                        'isNullable' => true,
                        'isUnique' => false,
                        'name' => 'datePublished',
                        'range' => 'Date',
                    ],
                    'headline' => [
                        'cardinality' => CardinalitiesExtractor::CARDINALITY_UNKNOWN,
                        'isArray' => false,
                        'isCustom' => false,
                        'isEnum' => false,
                        'isId' => false,
                        'isReadable' => true,
                        'isWritable' => true,
                        'isNullable' => true,
                        'isUnique' => false,
                        'name' => 'headline',
                        'range' => 'Text',
                    ],
                    'isFamilyFriendly' => [
                        'cardinality' => CardinalitiesExtractor::CARDINALITY_0_1,
                        'isArray' => false,
                        'isCustom' => false,
                        'isEnum' => false,
                        'isId' => false,
                        'isReadable' => true,
                        'isWritable' => true,
                        'isNullable' => true,
                        'isUnique' => false,
                        'name' => 'isFamilyFriendly',
                        'range' => 'Boolean',
                    ],
                ],
                'hasChild' => true,
                'isEnum' => false,
                'name' => 'CreativeWork',
                'namespace' => 'AppBundle\Entity',
                'parent' => 'Thing',
            ],
            'Person' => [
                'abstract' => false,
                'embeddable' => false,
                'fields' => [
                    'id' => [
                        'cardinality' => CardinalitiesExtractor::CARDINALITY_1_1,
                        'isArray' => false,
                        'isCustom' => true,
                        'isEnum' => false,
                        'isId' => true,
                        'isReadable' => true,
                        'isWritable' => true,
                        'isNullable' => false,
                        'isUnique' => false,
                        'name' => 'id',
                        'range' => 'Integer',
                    ],
                ],
                'hasChild' => false,
                'isEnum' => false,
                'name' => 'Person',
                'namespace' => 'AppBundle\Entity',
                'parent' => 'Thing',
            ],
            'SocialMediaPosting' => [
                'abstract' => true,
                'embeddable' => false,
                'fields' => [
                    'sharedContent' => [
                        'cardinality' => CardinalitiesExtractor::CARDINALITY_UNKNOWN,
                        'isArray' => false,
                        'isCustom' => false,
                        'isEnum' => false,
                        'isId' => false,
                        'isReadable' => true,
                        'isWritable' => true,
                        'isNullable' => true,
                        'isUnique' => false,
                        'name' => 'sharedContent',
                        'range' => 'CreativeWork',
                    ],
                ],
                'hasChild' => true,
                'isEnum' => false,
                'name' => 'SocialMediaPosting',
                'namespace' => 'AppBundle\Entity',
                'parent' => 'Article',
            ],
            'Thing' => [
                'abstract' => true,
                'embeddable' => false,
                'fields' => [
                    'name' => [
                        'cardinality' => CardinalitiesExtractor::CARDINALITY_0_1,
                        'isArray' => false,
                        'isCustom' => false,
                        'isEnum' => false,
                        'isId' => false,
                        'isReadable' => true,
                        'isWritable' => true,
                        'isNullable' => true,
                        'isUnique' => false,
                        'name' => 'name',
                        'range' => 'Text',
                    ],
                ],
                'hasChild' => true,
                'isEnum' => false,
                'name' => 'Thing',
                'namespace' => 'AppBundle\Entity',
                'parent' => false,
            ],
        ];
    }

    private function getContextMatcher(array $class): \Closure
    {
        $config = $this->getConfig();

        return function ($context) use ($config, $class) {
            if (!isset($context['config']) || $config !== $context['config']) {
                return false;
            }

            $baseClass = $class;
            unset($baseClass['fields']);

            if (!isset($context['class']) || !\is_array($context['class']) || $this->arrayEqual($baseClass, array_intersect_key($context['class'], $baseClass))) {
                return false;
            }

            if (array_keys($class['fields']) === array_keys($context['class']['fields'])) {
                return false;
            }

            return true;
        };
    }

    private function arrayEqual(array $a, array $b): bool
    {
        return \count($a) === \count($b) && !array_diff($a, $b);
    }
}
