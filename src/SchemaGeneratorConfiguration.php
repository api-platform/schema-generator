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

use ApiPlatform\SchemaGenerator\AnnotationGenerator\PhpDocAnnotationGenerator;
use ApiPlatform\SchemaGenerator\AttributeGenerator\ApiPlatformCoreAttributeGenerator;
use ApiPlatform\SchemaGenerator\AttributeGenerator\ConstraintAttributeGenerator;
use ApiPlatform\SchemaGenerator\AttributeGenerator\DoctrineOrmAttributeGenerator;
use ApiPlatform\SchemaGenerator\AttributeGenerator\SerializerGroupsAttributeGenerator;
use Symfony\Component\Config\Definition\Builder\NodeBuilder;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Schema Generator Configuration.
 *
 * @author Kévin Dunglas <dunglas@gmail.com>
 */
final class SchemaGeneratorConfiguration implements ConfigurationInterface
{
    public const SCHEMA_ORG_URI = 'https://schema.org/version/latest/schemaorg-current-https.rdf';
    public const GOOD_RELATIONS_URI = 'https://archive.org/services/purl/goodrelations/v1.owl';
    public const SCHEMA_ORG_NAMESPACE = 'https://schema.org/';

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

        /* @see https://yaml.org/type/omap.html */
        $transformOmap = fn (array $nodeConfig) => !empty(array_filter(
            $nodeConfig,
            fn ($v, $k) => \is_int($k) && \is_array($v) && 1 === \count($v) && \is_string(array_keys($v)[0]),
            \ARRAY_FILTER_USE_BOTH
        ))
            ? array_reduce(array_values($nodeConfig), fn (array $map, array $v) => $map + $v, [])
            : $nodeConfig;

        // @phpstan-ignore-next-line node is not null
        $attributesNode = fn () => (new NodeBuilder())
            ->arrayNode('attributes')
                ->info('Attributes (merged with generated attributes)')
                ->variablePrototype()->end()
                ->beforeNormalization()
                    ->ifArray()
                    ->then($transformOmap)
                ->end();

        $treeBuilder = new TreeBuilder('config');

        $treeBuilder
            ->getRootNode()
            ->children()
                ->arrayNode('openApi')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('file')->defaultNull()->end()
                    ->end()
                ->end()
                ->arrayNode('vocabularies')
                    ->info('RDF vocabularies')
                    ->defaultValue([self::SCHEMA_ORG_URI => ['format' => 'rdfxml']])
                    ->beforeNormalization()
                        ->ifArray()
                        ->then(fn (array $v) => array_map(fn ($rdf) => \is_scalar($rdf) ? ['uri' => $rdf] : $rdf, $v))
                    ->end()
                    ->useAttributeAsKey('uri')
                    ->arrayPrototype()
                        ->children()
                            ->scalarNode('uri')->info('RDF vocabulary to use')->example('https://schema.org/version/latest/schemaorg-current-https.rdf')->end()
                            ->scalarNode('format')->defaultNull()->info('RDF vocabulary format')->example('rdfxml')->end()
                            ->booleanNode('allTypes')->defaultNull()->info('Generate all types for this vocabulary, even if an explicit configuration exists. If allTypes is enabled globally, it can be disabled for this particular vocabulary')->end()
                            ->append($attributesNode())
                        ->end()
                    ->end()
                ->end()
                ->scalarNode('vocabularyNamespace')->defaultValue(self::SCHEMA_ORG_NAMESPACE)->info('Namespace of the vocabulary to import')->example('http://www.w3.org/ns/activitystreams#')->end()
                ->arrayNode('relations')
                    ->info('OWL relation files containing cardinality information in the GoodRelations format')
                    ->example(self::GOOD_RELATIONS_URI)
                    ->defaultValue([self::GOOD_RELATIONS_URI])
                    ->scalarPrototype()->end()
                ->end()
                ->booleanNode('debug')->defaultFalse()->info('Debug mode')->end()
                ->booleanNode('apiPlatformOldAttributes')->defaultFalse()->info('Use old API Platform attributes (API Platform < 2.7)')->end()
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
                ->scalarNode('header')->defaultNull()->info('A license or any text to use as header of generated files')->example('// (c) Kévin Dunglas <dunglas@gmail.com>')->end()
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
                ->arrayNode('uses')
                    ->info('Custom uses (for instance if you use a custom attribute)')
                    ->useAttributeAsKey('name')
                    ->arrayPrototype()
                        ->children()
                            ->scalarNode('name')->cannotBeEmpty()->info('Name of this use')->example('App\Attributes\MyAttribute')->end()
                            ->scalarNode('alias')->defaultNull()->info('The alias to use for this use')->end()
                        ->end()
                    ->end()
                ->end()
                ->arrayNode('doctrine')
                    ->addDefaultsIfNotSet()
                    ->info('Doctrine')
                    ->children()
                        ->booleanNode('useCollection')->defaultTrue()->info('Use Doctrine\'s ArrayCollection instead of standard arrays')->end()
                        ->scalarNode('resolveTargetEntityConfigPath')->defaultNull()->info('The Resolve Target Entity Listener config file path')->end()
                        ->enumNode('resolveTargetEntityConfigType')->defaultValue('XML')->values(['XML', 'yaml'])->info('The Resolve Target Entity Listener config file type')->end()
                        ->arrayNode('inheritanceAttributes')
                            ->info('Doctrine inheritance attributes (if set, no other attributes are generated)')
                            ->variablePrototype()->end()
                            ->beforeNormalization()
                                ->ifArray()
                                ->then($transformOmap)
                            ->end()
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
                    ->scalarPrototype()->end()
                ->end()
                ->booleanNode('allTypes')->defaultFalse()->info('Generate all types, even if an explicit configuration exists')->end()
                ->booleanNode('resolveTypes')->defaultFalse()->info('If a type is present in a vocabulary but not explicitly imported (types) or if the vocabulary is not totally imported (allTypes), it will be generated')->end()
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
                            ->append($attributesNode())
                            ->scalarNode('parent')->defaultFalse()->info('The parent class, set to false for a top level class')->end()
                            ->scalarNode('guessFrom')->defaultValue('Thing')->info('If declaring a custom class, this will be the class from which properties type will be guessed')->end()
                            ->arrayNode('operations')
                                ->info('Operations for the class')
                                ->variablePrototype()->end()
                            ->end()
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
                                        ->arrayNode('ormColumn')
                                            ->info('The doctrine column attribute content')
                                            ->example('{type: "decimal", precision: 5, scale: 1, options: {comment: "my comment"}}')
                                            ->variablePrototype()->end()
                                        ->end()
                                        ->arrayNode('groups')
                                            ->info('Symfony Serialization Groups')
                                            ->scalarPrototype()->end()
                                        ->end()
                                        ->scalarNode('mappedBy')->defaultNull()->info('The doctrine mapped by attribute')->example('partOfSeason')->end()
                                        ->scalarNode('inversedBy')->defaultNull()->info('The doctrine inversed by attribute')->example('episodes')->end()
                                        ->booleanNode('readable')->defaultTrue()->info('Is the property readable?')->end()
                                        ->booleanNode('writable')->defaultTrue()->info('Is the property writable?')->end()
                                        ->booleanNode('nullable')->defaultTrue()->info('Is the property nullable?')->end()
                                        ->booleanNode('required')->defaultTrue()->info('Is the property required?')->end()
                                        ->booleanNode('unique')->defaultFalse()->info('The property unique')->end()
                                        ->booleanNode('embedded')->defaultFalse()->info('Is the property embedded?')->end()
                                        ->scalarNode('columnPrefix')->defaultFalse()->info('The property columnPrefix')->end()
                                        ->append($attributesNode())
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
                    ])
                    ->scalarPrototype()->end()
                ->end()
                ->arrayNode('attributeGenerators')
                    ->info('Attribute generators to use')
                    ->defaultValue([
                        DoctrineOrmAttributeGenerator::class,
                        ApiPlatformCoreAttributeGenerator::class,
                        ConstraintAttributeGenerator::class,
                        SerializerGroupsAttributeGenerator::class,
                    ])
                    ->scalarPrototype()->end()
                ->end()
                ->arrayNode('generatorTemplates')
                    ->info('Directories for custom generator twig templates')
                    ->scalarPrototype()->end()
                ->end()
            ->end();

        return $treeBuilder;
    }
}
