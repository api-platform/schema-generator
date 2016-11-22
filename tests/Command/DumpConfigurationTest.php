<?php

/*
 * This file is part of the API Platform project.
 *
 * (c) Kévin Dunglas <dunglas@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ApiPlatform\SchemaGenerator\Tests;

use ApiPlatform\SchemaGenerator\Command\DumpConfigurationCommand;
use Symfony\Component\Console\Tester\CommandTester;

/**
 * @author Kévin Dunglas <dunglas@gmail.com>
 */
class DumpConfigurationTest extends \PHPUnit_Framework_TestCase
{
    public function testDumpConfiguration()
    {
        $commandTester = new CommandTester(new DumpConfigurationCommand());
        $this->assertEquals(0, $commandTester->execute([]));
        $this->assertEquals(<<<YAML
config:

    # RDFa files
    rdfa:

        # RDFa URI to use
        uri:                  'https://schema.org/docs/schema_org_rdfa.html' # Example: https://schema.org/docs/schema_org_rdfa.html

        # RDFa URI data format
        format:               null # Example: rdfxml

    # OWL relation files to use
    relations:

        # Default:
        - https://purl.org/goodrelations/v1.owl

    # Debug mode
    debug:                false

    # Automatically add an id field to entities
    generateId:           true

    # Generate interfaces and use Doctrine's Resolve Target Entity feature
    useInterface:         false

    # Emit a warning if a property is not derived from GoodRelations
    checkIsGoodRelations:  false

    # A license or any text to use as header of generated files
    header:               false # Example: // (c) Kévin Dunglas <dunglas@gmail.com>

    # PHP namespaces
    namespaces:

        # The namespace of the generated entities
        entity:               AppBundle\Entity # Example: Acme\Entity

        # The namespace of the generated enumerations
        enum:                 AppBundle\Enum # Example: Acme\Enum

        # The namespace of the generated interfaces
        interface:            AppBundle\Model # Example: Acme\Model

    # Doctrine
    doctrine:

        # Use Doctrine's ArrayCollection instead of standard arrays
        useCollection:        true

        # The Resolve Target Entity Listener config file pass
        resolveTargetEntityConfigPath:  null

    # The value of the phpDoc's @author annotation
    author:               false # Example: Kévin Dunglas <dunglas@gmail.com>

    # Visibility of entities fields
    fieldVisibility:      private # One of "private"; "protected"; "public"

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
            parent:               null

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

                    # The property nullable
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
        - ApiPlatform\SchemaGenerator\AnnotationGenerator\ConstraintAnnotationGenerator
        - ApiPlatform\SchemaGenerator\AnnotationGenerator\DoctrineOrmAnnotationGenerator
        - ApiPlatform\SchemaGenerator\AnnotationGenerator\ApiPlatformCoreAnnotationGenerator


YAML
, $commandTester->getDisplay());
    }
}
