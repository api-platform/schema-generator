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
        $this->assertEquals(<<<'YAML'
config:

    # RDF vocabularies
    vocabularies:

        # Prototype
        -

            # RDF vocabulary to use
            uri:                  'https://schema.org/version/latest/schemaorg-current-http.rdf' # Example: 'https://schema.org/version/latest/schemaorg-current-http.rdf'

            # RDF vocabulary format
            format:               null # Example: rdfxml

    # Namespace of the vocabulary to import
    vocabularyNamespace:  'http://schema.org/' # Example: 'http://www.w3.org/ns/activitystreams#'

    # OWL relation files containing cardinality information in the GoodRelations format
    relations:            # Example: 'https://purl.org/goodrelations/v1.owl'

        # Default:
        - https://purl.org/goodrelations/v1.owl

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

        # Set to "child" to generate the id on the child class, and "parent" to use the parent class instead.
        onClass:              child # One of "child"; "parent"

    # Generate interfaces and use Doctrine's Resolve Target Entity feature
    useInterface:         false

    # Emit a warning if a property is not derived from GoodRelations
    checkIsGoodRelations: false

    # A license or any text to use as header of generated files
    header:               false # Example: '// (c) Kévin Dunglas <dunglas@gmail.com>'

    # PHP namespaces
    namespaces:

        # The global namespace's prefix
        prefix:               null # Example: App\

        # The namespace of the generated entities
        entity:               App\Entity # Example: App\Entity

        # The namespace of the generated enumerations
        enum:                 App\Enum # Example: App\Enum

        # The namespace of the generated interfaces
        interface:            App\Model # Example: App\Model

    # Doctrine
    doctrine:

        # Use Doctrine's ArrayCollection instead of standard arrays
        useCollection:        true

        # The Resolve Target Entity Listener config file pass
        resolveTargetEntityConfigPath: null

        # Doctrine inheritance annotations (if set, no other annotations are generated)
        inheritanceAnnotations: []

    # Symfony Validator Component
    validator:

        # Generate @Assert\Type annotation
        assertType:           false

    # The value of the phpDoc's @author annotation
    author:               false # Example: 'Kévin Dunglas <dunglas@gmail.com>'

    # Visibility of entities fields
    fieldVisibility:      private # One of "private"; "protected"; "public"

    # Set this flag to false to not generate getter, setter, adder and remover methods
    accessorMethods:      true

    # Set this flag to true to generate fluent setter, adder and remover methods
    fluentMutatorMethods: false
    rangeMapping:

        # Prototype
        name:                 ~

    # Generate all types, even if an explicit configuration exists
    allTypes:             false

    # Types to import from the vocabulary
    types:

        # Prototype
        id:

            # Exclude this type, even if "allTypes" is set to true"
            exclude:              false

            # Namespace of the vocabulary of this type (defaults to the global "vocabularyNamespace" entry)
            vocabularyNamespace:  null # Example: 'http://www.w3.org/ns/activitystreams#'

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

                # Doctrine annotations (if set, no other annotations are generated)
                annotations:          []

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

                    # Exclude this property, even if "allProperties" is set to true"
                    exclude:              false

                    # The property range
                    range:                null # Example: Offer

                    # The relation table name
                    relationTableName:    null # Example: organization_member
                    cardinality:          unknown # One of "(0..1)"; "(0..*)"; "(1..1)"; "(1..*)"; "(*..0)"; "(*..1)"; "(*..*)"; "unknown"

                    # The doctrine column annotation content
                    ormColumn:            null # Example: 'type="decimal", precision=5, scale=1, options={"comment" = "my comment"}'

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
            $commandTester->getDisplay()
        );
    }
}
