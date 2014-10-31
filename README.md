# PHP Schema.org Model

Various tools to generate a data model based on [Schema.org](http://schema.org) vocables.

*Work In Progress.*

[![Build Status](https://travis-ci.org/dunglas/php-schema.org-model.png?branch=master)](https://travis-ci.org/dunglas/php-schema.org-model)
[![SensioLabsInsight](https://insight.sensiolabs.com/projects/87ec89e6-57cd-4ac0-9ab1-d4549c5425c5/mini.png)](https://insight.sensiolabs.com/projects/87ec89e6-57cd-4ac0-9ab1-d4549c5425c5)

## Installation

Use [Composer](http://getcomposer.org).

    composer create-project dunglas/php-schema.org-model

## Doctrine entities generator

Generates Doctrine entities from Schema.org vocables.

Usage:

    bin/schema my-output-directory/ [my-config.yml]

### Configuration

See [echoppe.yml](examples/config/echoppe.yml) file.

### Configuration reference

```yaml
# RDFa files to use
rdfa:

    # Default:
    - https://raw.githubusercontent.com/rvguha/schemaorg/master/data/schema.rdfa

# OWL relation files to use
relations:

    # Default:
    - http://purl.org/goodrelations/v1.owl

# Debug mode
debug:                false

# Use Doctrine's Resolve Target Entity feature
useRte:               false

# Emit a warning if a property is not derived from GoodRelations
checkIsGoodRelations:  false

# A license or any text to use as header of generated files
header:               false # Example: // (c) Kévin Dunglas <dunglas@gmail.com>

# PHP namespaces
namespaces:

    # The namespace of the generated entities
    entity:               SchemaOrg\Entity # Example: Acme\Entity

    # The namespace of the generated enumerations
    enum:                 SchemaOrg\Enum # Example: Acme\Enum

    # The namespace of the generated interfaces
    interface:            SchemaOrg\Model # Example: Acme\Model

# The value of the phpDoc's @author annotation
author:               false # Example: Kévin Dunglas <dunglas@gmail.com>

# Visibility of entities fields
fieldVisibility:      ~ # One of "private"; "protected"; "public"

# Schema.org's types to use
types:

    # Prototype
    id:

        # Type namespaces
        namespaces:

            # The namespace for the generated class (override any other defined namespace)
            class:                null

            # The namespace for the generated interface (override any other defined namespace)
            interface:            null
        doctrine:

            # The Doctrine inheritance mapping type
            inheritanceMapping:   null

        # The parent class
        parent:               null

        # Properties of this type to use
        properties:

            # Prototype
            id:

                # The property range
                range:                null # Example: Offer

# Annotation generators to use
annotationGenerators:

    # Defaults:
    - SchemaOrgModel\AnnotationGenerator\PhpDocAnnotationGenerator
    - SchemaOrgModel\AnnotationGenerator\ConstraintAnnotationGenerator
    - SchemaOrgModel\AnnotationGenerator\DoctrineAnnotationGenerator
```

## Cardinalities extractor

Extracts property's cardinality.
[GoodRelations](http://www.heppnetz.de/projects/goodrelations/) data are used when applicable. Other cardinalities are guessed using the property's comment.
When the cardinality cannot be automatically extracted, it's value is set to `unknown`.

Usage:

    php vendor/bin/schema.php schema:extract-cardinalities
