<?php

/*
 * This file is part of the API Platform project.
 *
 * (c) Kévin Dunglas <dunglas@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ApiPlatform\SchemaGenerator;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Types Generator Configuration.
 *
 * @author Kévin Dunglas <dunglas@gmail.com>
 */
class TypesGeneratorConfiguration implements ConfigurationInterface
{
    const SCHEMA_ORG_RDFA_URL = 'https://schema.org/docs/schema_org_rdfa.html';
    const GOOD_RELATIONS_OWL_URL = 'https://purl.org/goodrelations/v1.owl';

    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('config');
        $rootNode
            ->children()
                ->arrayNode('rdfa')
                    ->info('RDFa files')
                    ->defaultValue([
                        ['uri' => self::SCHEMA_ORG_RDFA_URL, 'format' => null],
                    ])
                    ->beforeNormalization()
                        ->ifArray()
                        ->then(function (array $v) {
                            return array_map(
                                function ($rdfa) {
                                    return is_scalar($rdfa) ? ['uri' => $rdfa, 'format' => null] : $rdfa;
                                },
                                $v
                            );
                        })
                    ->end()
                    ->prototype('array')
                        ->children()
                            ->scalarNode('uri')->defaultValue(self::SCHEMA_ORG_RDFA_URL)->info('RDFa URI to use')->example(self::SCHEMA_ORG_RDFA_URL)->end()
                            ->scalarNode('format')->defaultNull()->info('RDFa URI data format')->example('rdfxml')->end()
                        ->end()
                    ->end()
                ->end()
                ->arrayNode('relations')
                    ->info('OWL relation files to use')
                    ->defaultValue([self::GOOD_RELATIONS_OWL_URL])
                    ->prototype('scalar')->end()
                ->end()
                ->booleanNode('debug')->defaultFalse()->info('Debug mode')->end()
                ->booleanNode('generateId')->defaultTrue()->info('Automatically add an id field to entities')->end()
                ->booleanNode('useInterface')->defaultFalse()->info('Generate interfaces and use Doctrine\'s Resolve Target Entity feature')->end()
                ->booleanNode('checkIsGoodRelations')->defaultFalse()->info('Emit a warning if a property is not derived from GoodRelations')->end()
                ->scalarNode('header')->defaultFalse()->info('A license or any text to use as header of generated files')->example('// (c) Kévin Dunglas <dunglas@gmail.com>')->end()
                ->arrayNode('namespaces')
                    ->addDefaultsIfNotSet()
                    ->info('PHP namespaces')
                    ->children()
                        ->scalarNode('entity')->defaultValue('AppBundle\Entity')->info('The namespace of the generated entities')->example('Acme\Entity')->end()
                        ->scalarNode('enum')->defaultValue('AppBundle\Enum')->info('The namespace of the generated enumerations')->example('Acme\Enum')->end()
                        ->scalarNode('interface')->defaultValue('AppBundle\Model')->info('The namespace of the generated interfaces')->example('Acme\Model')->end()
                    ->end()
                ->end()
                ->arrayNode('doctrine')
                    ->addDefaultsIfNotSet()
                    ->info('Doctrine')
                    ->children()
                        ->booleanNode('useCollection')->defaultTrue()->info('Use Doctrine\'s ArrayCollection instead of standard arrays')->end()
                        ->scalarNode('resolveTargetEntityConfigPath')->defaultNull()->info('The Resolve Target Entity Listener config file pass')->end()
                    ->end()
                ->end()
                ->scalarNode('author')->defaultFalse()->info('The value of the phpDoc\'s @author annotation')->example('Kévin Dunglas <dunglas@gmail.com>')->end()
                ->enumNode('fieldVisibility')->values(['private', 'protected', 'public'])->defaultValue('private')->cannotBeEmpty()->info('Visibility of entities fields')->end()
                ->arrayNode('types')
                    ->beforeNormalization()
                        ->always()
                        ->then(function ($v) {
                            foreach ($v as $key => $type) {
                                if (!isset($type['properties'])) {
                                    $v[$key]['allProperties'] = true;
                                }
                            }

                            return $v;
                        })
                    ->end()
                    ->info('Schema.org\'s types to use')
                    ->useAttributeAsKey('id')
                    ->prototype('array')
                        ->children()
                            ->scalarNode('vocabularyNamespace')->defaultValue(TypesGenerator::SCHEMA_ORG_NAMESPACE)->info('Namespace of the vocabulary the type belongs to.')->end()
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
                                    ->scalarNode('inheritanceMapping')->defaultNull()->info('The Doctrine inheritance mapping type (override the guessed one)')->end()
                                ->end()
                            ->end()
                            ->scalarNode('parent')->defaultNull()->info('The parent class, set to false for a top level class')->end()
                            ->scalarNode('guessFrom')->defaultValue('Thing')->info('If declaring a custom class, this will be the class from which properties type will be guessed')->end()
                            ->booleanNode('allProperties')->defaultFalse()->info('Import all existing properties')->end()
                            ->arrayNode('properties')
                                ->info('Properties of this type to use')
                                ->useAttributeAsKey('id')
                                ->prototype('array')
                                    ->addDefaultsIfNotSet()
                                    ->children()
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
                                        ->scalarNode('nullable')->defaultTrue()->info('The property nullable')->end()
                                        ->scalarNode('unique')->defaultFalse()->info('The property unique')->end()
                                        ->booleanNode('embedded')->defaultFalse()->info('Is the property embedded?')->end()
                                        ->booleanNode('columnPrefix')->defaultFalse()->info('The property columnPrefix')->end()
                                    ->end()
                                ->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
                ->arrayNode('annotationGenerators')
                    ->info('Annotation generators to use')
                    ->defaultValue([
                        'ApiPlatform\SchemaGenerator\AnnotationGenerator\PhpDocAnnotationGenerator',
                        'ApiPlatform\SchemaGenerator\AnnotationGenerator\ConstraintAnnotationGenerator',
                        'ApiPlatform\SchemaGenerator\AnnotationGenerator\DoctrineOrmAnnotationGenerator',
                        'ApiPlatform\SchemaGenerator\AnnotationGenerator\ApiPlatformCoreAnnotationGenerator',
                    ])
                    ->prototype('scalar')->end()
                ->end()
            ->end();

        return $treeBuilder;
    }
}
