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

namespace ApiPlatform\SchemaGenerator;

use ApiPlatform\SchemaGenerator\AnnotationGenerator\ApiPlatformCoreAnnotationGenerator;
use ApiPlatform\SchemaGenerator\AnnotationGenerator\ConstraintAnnotationGenerator;
use ApiPlatform\SchemaGenerator\AnnotationGenerator\DoctrineOrmAnnotationGenerator;
use ApiPlatform\SchemaGenerator\AnnotationGenerator\PhpDocAnnotationGenerator;
use ApiPlatform\SchemaGenerator\AnnotationGenerator\SerializerGroupsAnnotationGenerator;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Types Generator Configuration.
 *
 * @author Kévin Dunglas <dunglas@gmail.com>
 */
final class TypesGeneratorConfiguration implements ConfigurationInterface
{
    public const SCHEMA_ORG_URI = 'https://schema.org/version/latest/schemaorg-current-http.rdf';
    public const GOOD_RELATIONS_URI = 'https://purl.org/goodrelations/v1.owl';
    public const SCHEMA_ORG_NAMESPACE = 'http://schema.org/';

    private ?string $defaultPrefix;

    public function __construct(?string $defaultPrefix = null)
    {
        $this->defaultPrefix = $defaultPrefix;
    }

    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $namespacePrefix = $this->defaultPrefix ?? 'App\\';

        $treeBuilder = new TreeBuilder('config');

        $treeBuilder
            ->getRootNode()
            ->children()
                ->arrayNode('vocabularies')
                    ->info('RDF vocabularies')
                    ->defaultValue([['uri' => self::SCHEMA_ORG_URI, 'format' => 'rdfxml']])
                    ->beforeNormalization()
                        ->ifArray()
                        ->then(static function (array $v) {
                            return array_map(
                                static function ($rdf) {
                                    return is_scalar($rdf) ? ['uri' => $rdf, 'format' => null] : $rdf;
                                },
                                $v
                            );
                        })
                    ->end()
                    ->arrayPrototype()
                        ->children()
                            ->scalarNode('uri')->defaultValue(self::SCHEMA_ORG_URI)->info('RDF vocabulary to use')->example('https://schema.org/version/latest/schemaorg-current-http.rdf')->end()
                            ->scalarNode('format')->defaultNull()->info('RDF vocabulary format')->example('rdfxml')->end()
                        ->end()
                    ->end()
                ->end()
                ->scalarNode('vocabularyNamespace')->defaultValue(self::SCHEMA_ORG_NAMESPACE)->info('Namespace of the vocabulary to import')->example('http://www.w3.org/ns/activitystreams#')->end()
                ->arrayNode('relations')
                    ->info('OWL relation files containing cardinality information in the GoodRelations format')
                    ->example('https://purl.org/goodrelations/v1.owl')
                    ->defaultValue([self::GOOD_RELATIONS_URI])
                    ->prototype('scalar')->end()
                ->end()
                ->booleanNode('debug')->defaultFalse()->info('Debug mode')->end()
                ->arrayNode('id')
                    ->addDefaultsIfNotSet()
                    ->info('IDs configuration')
                    ->children()
                        ->booleanNode('generate')->defaultTrue()->info('Automatically add an id field to entities')->end()
                        ->enumNode('generationStrategy')->defaultValue('auto')->values(['auto', 'none', 'uuid', 'mongoid'])->info('The ID generation strategy to use ("none" to not let the database generate IDs).')->end()
                        ->booleanNode('writable')->defaultFalse()->info('Is the ID writable? Only applicable if "generationStrategy" is "uuid".')->end()
                        ->enumNode('onClass')->defaultValue('child')->values(['child', 'parent'])->info('Set to "child" to generate the id on the child class, and "parent" to use the parent class instead.')->end()
                    ->end()
                ->end()
                ->booleanNode('useInterface')->defaultFalse()->info('Generate interfaces and use Doctrine\'s Resolve Target Entity feature')->end()
                ->booleanNode('checkIsGoodRelations')->defaultFalse()->info('Emit a warning if a property is not derived from GoodRelations')->end()
                ->scalarNode('header')->defaultFalse()->info('A license or any text to use as header of generated files')->example('// (c) Kévin Dunglas <dunglas@gmail.com>')->end()
                ->arrayNode('namespaces')
                    ->addDefaultsIfNotSet()
                    ->info('PHP namespaces')
                    ->children()
                        ->scalarNode('prefix')->defaultValue($this->defaultPrefix)->info('The global namespace\'s prefix')->example('App\\')->end()
                        ->scalarNode('entity')->defaultValue("{$namespacePrefix}Entity")->info('The namespace of the generated entities')->example('App\Entity')->end()
                        ->scalarNode('enum')->defaultValue("{$namespacePrefix}Enum")->info('The namespace of the generated enumerations')->example('App\Enum')->end()
                        ->scalarNode('interface')->defaultValue("{$namespacePrefix}Model")->info('The namespace of the generated interfaces')->example('App\Model')->end()
                    ->end()
                ->end()
                ->arrayNode('doctrine')
                    ->addDefaultsIfNotSet()
                    ->info('Doctrine')
                    ->children()
                        ->booleanNode('useCollection')->defaultTrue()->info('Use Doctrine\'s ArrayCollection instead of standard arrays')->end()
                        ->scalarNode('resolveTargetEntityConfigPath')->defaultNull()->info('The Resolve Target Entity Listener config file pass')->end()
                        ->arrayNode('inheritanceAnnotations')
                            ->info('Doctrine inheritance annotations (if set, no other annotations are generated)')
                            ->prototype('scalar')->end()
                        ->end()
                    ->end()
                ->end()
                ->arrayNode('validator')
                    ->addDefaultsIfNotSet()
                    ->info('Symfony Validator Component')
                    ->children()
                        ->booleanNode('assertType')->defaultFalse()->info('Generate @Assert\Type annotation')->end()
                    ->end()
                ->end()
                ->scalarNode('author')->defaultFalse()->info('The value of the phpDoc\'s @author annotation')->example('Kévin Dunglas <dunglas@gmail.com>')->end()
                ->enumNode('fieldVisibility')->values(['private', 'protected', 'public'])->defaultValue('private')->cannotBeEmpty()->info('Visibility of entities fields')->end()
                ->booleanNode('accessorMethods')->defaultTrue()->info('Set this flag to false to not generate getter, setter, adder and remover methods')->end()
                ->booleanNode('fluentMutatorMethods')->defaultFalse()->info('Set this flag to true to generate fluent setter, adder and remover methods')->end()
                ->arrayNode('rangeMapping')
                    ->useAttributeAsKey('name')
                    ->prototype('scalar')->end()
                ->end()
                ->booleanNode('allTypes')->defaultFalse()->info('Generate all types, even if an explicit configuration exists')->end()
                ->arrayNode('types')
                    ->beforeNormalization()
                        ->always()
                        ->then(static function ($v) {
                            foreach ($v as $key => $type) {
                                $v[$key]['allProperties'] ??= !isset($type['properties']);
                            }

                            return $v;
                        })
                    ->end()
                    ->info('Types to import from the vocabulary')
                    ->useAttributeAsKey('id')
                    ->arrayPrototype()
                        ->children()
                            ->booleanNode('exclude')->defaultFalse()->info('Exclude this type, even if "allTypes" is set to true"')->end()
                            ->scalarNode('vocabularyNamespace')->defaultNull()->info('Namespace of the vocabulary of this type (defaults to the global "vocabularyNamespace" entry)')->example('http://www.w3.org/ns/activitystreams#')->end()
                            ->booleanNode('abstract')->defaultNull()->info('Is the class abstract? (null to guess)')->end()
                            ->booleanNode('embeddable')->defaultFalse()->info('Is the class embeddable?')->end()
                            ->arrayNode('namespaces')
                                ->addDefaultsIfNotSet()
                                ->info('Type namespaces')
                                ->children()
                                    ->scalarNode('class')->defaultNull()->info('The namespace for the generated class (override any other defined namespace)')->end()
                                    ->scalarNode('interface')->defaultNull()->info('The namespace for the generated interface (override any other defined namespace)')->end()
                                ->end()
                            ->end()
                            ->arrayNode('doctrine')
                                ->addDefaultsIfNotSet()
                                ->children()
                                    ->arrayNode('annotations')
                                        ->info('Doctrine annotations (if set, no other annotations are generated)')
                                        ->prototype('scalar')->end()
                                    ->end()
                                ->end()
                            ->end()
                            ->scalarNode('parent')->defaultFalse()->info('The parent class, set to false for a top level class')->end()
                            ->scalarNode('guessFrom')->defaultValue('Thing')->info('If declaring a custom class, this will be the class from which properties type will be guessed')->end()
                            ->booleanNode('allProperties')->defaultFalse()->info('Import all existing properties')->end()
                            ->arrayNode('properties')
                                ->info('Properties of this type to use')
                                ->useAttributeAsKey('id')
                                ->arrayPrototype()
                                    ->addDefaultsIfNotSet()
                                    ->children()
                                        ->booleanNode('exclude')->defaultFalse()->info('Exclude this property, even if "allProperties" is set to true"')->end()
                                        ->scalarNode('range')->defaultNull()->info('The property range')->example('Offer')->end()
                                        ->scalarNode('relationTableName')->defaultNull()->info('The relation table name')->example('organization_member')->end()
                                        ->enumNode('cardinality')->defaultValue(CardinalitiesExtractor::CARDINALITY_UNKNOWN)->values([
                                            CardinalitiesExtractor::CARDINALITY_0_1,
                                            CardinalitiesExtractor::CARDINALITY_0_N,
                                            CardinalitiesExtractor::CARDINALITY_1_1,
                                            CardinalitiesExtractor::CARDINALITY_1_N,
                                            CardinalitiesExtractor::CARDINALITY_N_0,
                                            CardinalitiesExtractor::CARDINALITY_N_1,
                                            CardinalitiesExtractor::CARDINALITY_N_N,
                                            CardinalitiesExtractor::CARDINALITY_UNKNOWN,
                                        ])->end()
                                        ->scalarNode('ormColumn')->defaultNull()->info('The doctrine column annotation content')->example('type="decimal", precision=5, scale=1, options={"comment" = "my comment"}')->end()
                                        ->arrayNode('groups')
                                            ->info('Symfony Serialization Groups')
                                            ->prototype('scalar')->end()
                                        ->end()
                                        ->scalarNode('mappedBy')->defaultNull()->info('The doctrine mapped by attribute')->example('partOfSeason')->end()
                                        ->scalarNode('inversedBy')->defaultNull()->info('The doctrine inversed by attribute')->example('episodes')->end()
                                        ->booleanNode('readable')->defaultTrue()->info('Is the property readable?')->end()
                                        ->booleanNode('writable')->defaultTrue()->info('Is the property writable?')->end()
                                        ->booleanNode('nullable')->defaultTrue()->info('Is the property nullable?')->end()
                                        ->booleanNode('unique')->defaultFalse()->info('The property unique')->end()
                                        ->booleanNode('embedded')->defaultFalse()->info('Is the property embedded?')->end()
                                        ->scalarNode('columnPrefix')->defaultFalse()->info('The property columnPrefix')->end()
                                    ->end()
                                ->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
                ->arrayNode('annotationGenerators')
                    ->info('Annotation generators to use')
                    ->defaultValue([
                        PhpDocAnnotationGenerator::class,
                        DoctrineOrmAnnotationGenerator::class,
                        ApiPlatformCoreAnnotationGenerator::class,
                        ConstraintAnnotationGenerator::class,
                        SerializerGroupsAnnotationGenerator::class,
                    ])
                    ->prototype('scalar')->end()
                ->end()
                ->arrayNode('generatorTemplates')
                    ->info('Directories for custom generator twig templates')
                    ->prototype('scalar')->end()
                ->end()
            ->end();

        return $treeBuilder;
    }
}
