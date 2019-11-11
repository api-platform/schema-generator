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

namespace ApiPlatform\SchemaGenerator\Tests\Command;

use ApiPlatform\SchemaGenerator\Command\DumpConfigurationCommand;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Tester\CommandTester;

/**
 * @author Kévin Dunglas <dunglas@gmail.com>
 */
class DumpConfigurationTest extends TestCase
{
    public function testDumpConfiguration(): void
    {
        $commandTester = new CommandTester(new DumpConfigurationCommand());
        $this->assertEquals(0, $commandTester->execute([]));
        $this->assertEquals(
            sprintf(
                <<<'YAML'
config:

    # RDFa files
    rdfa:

        # Prototype
        -

            # RDFa URI to use
            uri:                  %s # Example: https://schema.org/docs/schema_org_rdfa.html

            # RDFa URI data format
            format:               null # Example: rdfxml

    # OWL relation files to use
    relations:            # Example: https://purl.org/goodrelations/v1.owl

        # Default:
        - %s

    # Debug mode
    debug:                false

    # IDs configuration
    id:

        # Automatically add an id field to entities
        generate:             true

        # The ID generation strategy to use ("none" to not let the database generate IDs).
        generationStrategy:   auto # One of "auto"; "none"; "uuid"; "mongoid"

        # Is the ID writable? Only applicable if "generationStrategy" is "uuid".
        writable:             false

    # Generate interfaces and use Doctrine's Resolve Target Entity feature
    useInterface:         false

    # Emit a warning if a property is not derived from GoodRelations
    checkIsGoodRelations: false

    # A license or any text to use as header of generated files
    header:               false # Example: // (c) Kévin Dunglas <dunglas@gmail.com>

    # PHP namespaces
    namespaces:

        # The global namespace's prefix
        prefix:               null # Example: App\

        # The namespace of the generated entities
        entity:               AppBundle\Entity # Example: App\Entity

        # The namespace of the generated enumerations
        enum:                 AppBundle\Enum # Example: App\Enum

        # The namespace of the generated interfaces
        interface:            AppBundle\Model # Example: App\Model

    # Doctrine
    doctrine:

        # Use Doctrine's ArrayCollection instead of standard arrays
        useCollection:        true

        # The Resolve Target Entity Listener config file pass
        resolveTargetEntityConfigPath: null

    # Symfony Validator Component
    validator:

        # Generate @Assert\Type annotation
        assertType:           false

    # The value of the phpDoc's @author annotation
    author:               false # Example: Kévin Dunglas <dunglas@gmail.com>

    # Visibility of entities fields
    fieldVisibility:      private # One of "private"; "protected"; "public"

    # Set this flag to false to not generate getter, setter, adder and remover methods
    accessorMethods:      true

    # Set this flag to true to generate fluent setter, adder and remover methods
    fluentMutatorMethods: false

    # Schema.org's types to use
    types:

        # Prototype
        id:

            # Namespace of the vocabulary the type belongs to.
            vocabularyNamespace:  'http://schema.org/'

            # Is the class abstract? (null to guess)
            abstract:             null

            # Is the class embeddable?
            embeddable:           false

            # Type namespaces
            namespaces:

                # The namespace for the generated class (override any other defined namespace)
                class:                null

                # The namespace for the generated interface (override any other defined namespace)
                interface:            null
            doctrine:

                # The Doctrine inheritance mapping type (override the guessed one)
                inheritanceMapping:   null

            # The parent class, set to false for a top level class
            parent:               false

            # If declaring a custom class, this will be the class from which properties type will be guessed
            guessFrom:            Thing

            # Import all existing properties
            allProperties:        false

            # Properties of this type to use
            properties:

                # Prototype
                id:

                    # The property range
                    range:                null # Example: Offer

                    # The relation table name
                    relationTableName:    null # Example: organization_member
                    cardinality:          unknown # One of "(0..1)"; "(0..*)"; "(1..1)"; "(1..*)"; "(*..0)"; "(*..1)"; "(*..*)"; "unknown"

                    # The doctrine column annotation content
                    ormColumn:            null # Example: type="decimal", precision=5, scale=1, options={"comment" = "my comment"}

                    # Symfony Serialization Groups
                    groups:               []

                    # The doctrine mapped by attribute
                    mappedBy:             null # Example: partOfSeason

                    # The doctrine inversed by attribute
                    inversedBy:           null # Example: episodes

                    # Is the property readable?
                    readable:             true

                    # Is the property writable?
                    writable:             true

                    # Is the property nullable?
                    nullable:             true

                    # The property unique
                    unique:               false

                    # Is the property embedded?
                    embedded:             false

                    # The property columnPrefix
                    columnPrefix:         false

    # Annotation generators to use
    annotationGenerators:

        # Defaults:
        - ApiPlatform\SchemaGenerator\AnnotationGenerator\PhpDocAnnotationGenerator
        - ApiPlatform\SchemaGenerator\AnnotationGenerator\DoctrineOrmAnnotationGenerator
        - ApiPlatform\SchemaGenerator\AnnotationGenerator\ApiPlatformCoreAnnotationGenerator
        - ApiPlatform\SchemaGenerator\AnnotationGenerator\ConstraintAnnotationGenerator
        - ApiPlatform\SchemaGenerator\AnnotationGenerator\SerializerGroupsAnnotationGenerator

    # Directories for custom generator twig templates
    generatorTemplates:   []


YAML
                ,
                str_replace('generator/data', 'generator/src/../data', realpath(__DIR__.'/../../data/schema.rdfa')),
                str_replace('generator/data', 'generator/src/../data', realpath(__DIR__.'/../../data/v1.owl'))
            ),
            $commandTester->getDisplay()
        );
    }
}
