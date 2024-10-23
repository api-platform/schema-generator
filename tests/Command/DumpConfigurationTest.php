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
    openApi:
        file:                 null

    # RDF vocabularies
    vocabularies:

        # Prototype
        uri:

            # RDF vocabulary to use
            uri:                  ~ # Example: 'https://schema.org/version/latest/schemaorg-current-https.rdf'

            # RDF vocabulary format
            format:               null # Example: rdfxml

            # Generate all types for this vocabulary, even if an explicit configuration exists. If allTypes is enabled globally, it can be disabled for this particular vocabulary
            allTypes:             null

            # Attributes (merged with generated attributes)
            attributes:           []

    # Namespace of the vocabulary to import
    vocabularyNamespace:  'https://schema.org/' # Example: 'http://www.w3.org/ns/activitystreams#'

    # Relations configuration
    relations:

        # OWL relation URIs containing cardinality information in the GoodRelations format
        uris:                 # Example: 'https://www.heppnetz.de/ontologies/goodrelations/v1.owl'

            # Default:
            - https://www.heppnetz.de/ontologies/goodrelations/v1.owl

        # The default cardinality to use when it cannot be extracted
        defaultCardinality:   (1..1) # One of "(0..1)"; "(0..*)"; "(1..1)"; "(1..*)"; "(*..0)"; "(*..1)"; "(*..*)"

    # Debug mode
    debug:                false

    # Use old API Platform attributes (API Platform < 2.7)
    apiPlatformOldAttributes: false

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
    header:               null # Example: '// (c) Kévin Dunglas <dunglas@gmail.com>'

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

    # Custom uses (for instance if you use a custom attribute)
    uses:

        # Prototype
        name:

            # Name of this use
            name:                 ~ # Example: App\Attributes\MyAttribute

            # The alias to use for this use
            alias:                null

    # Doctrine
    doctrine:

        # Use Doctrine's ArrayCollection instead of standard arrays
        useCollection:        true

        # The Resolve Target Entity Listener config file path
        resolveTargetEntityConfigPath: null

        # The Resolve Target Entity Listener config file type
        resolveTargetEntityConfigType: XML # One of "XML"; "yaml"

        # Doctrine inheritance attributes (if set, no other attributes are generated)
        inheritanceAttributes: []

        # The inheritance type to use when an entity is referenced by another and has child
        inheritanceType:      JOINED # One of "JOINED"; "SINGLE_TABLE"; "SINGLE_COLLECTION"; "TABLE_PER_CLASS"; "COLLECTION_PER_CLASS"; "NONE"

        # Maximum length of any given database identifier, like tables or column names
        maxIdentifierLength:  63

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

    # If a type is present in a vocabulary but not explicitly imported (types) or if the vocabulary is not totally imported (allTypes), it will be generated
    resolveTypes:         false

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

            # Attributes (merged with generated attributes)
            attributes:           []

            # The parent class, set to false for a top level class
            parent:               false

            # If declaring a custom class, this will be the class from which properties type will be guessed
            guessFrom:            Thing

            # Operations for the class
            operations:           []

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
                    cardinality:          unknown # One of "(0..1)"; "(0..*)"; "(1..1)"; "(1..*)"; "(*..0)"; "(*..1)"; "(*..*)"; "unknown"

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

                    # Is the property nullable? (if null, cardinality will be used: will be true if no cardinality found)
                    nullable:             null

                    # The property default value
                    defaultValue:         null

                    # Is the property required?
                    required:             true

                    # The property unique
                    unique:               false

                    # Is the property embedded?
                    embedded:             false

                    # Attributes (merged with generated attributes)
                    attributes:           []

    # Annotation generators to use
    annotationGenerators:

        # Default:
        - ApiPlatform\SchemaGenerator\AnnotationGenerator\PhpDocAnnotationGenerator

    # Attribute generators to use
    attributeGenerators:

        # Defaults:
        - ApiPlatform\SchemaGenerator\AttributeGenerator\DoctrineOrmAttributeGenerator
        - ApiPlatform\SchemaGenerator\AttributeGenerator\DoctrineOrmAssociationOverrideAttributeGenerator
        - ApiPlatform\SchemaGenerator\AttributeGenerator\ApiPlatformCoreAttributeGenerator
        - ApiPlatform\SchemaGenerator\AttributeGenerator\ConstraintAttributeGenerator
        - ApiPlatform\SchemaGenerator\AttributeGenerator\ConfigurationAttributeGenerator

    # Directories for custom generator twig templates
    generatorTemplates:   []


YAML
            ,
            $commandTester->getDisplay()
        );
    }
}
