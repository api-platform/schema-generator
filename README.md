# PHP Schema.org Model Scaffolding

Tool to generate a PHP data model from [Schema.org](http://schema.org) and [GoodRelations](http://www.heppnetz.de/projects/goodrelations/)
vocables.

[![Build Status](https://travis-ci.org/dunglas/php-schema.org-model.png?branch=master)](https://travis-ci.org/dunglas/php-schema.org-model)
[![SensioLabsInsight](https://insight.sensiolabs.com/projects/87ec89e6-57cd-4ac0-9ab1-d4549c5425c5/mini.png)](https://insight.sensiolabs.com/projects/87ec89e6-57cd-4ac0-9ab1-d4549c5425c5)

## Features

* [PSR](http://www.php-fig.org/) compliant entity generator including properties, getters and setters
* Full [PSR-5](https://github.com/php-fig/fig-standards/pull/169) compliant PHPDoc for classes, properties, constants (enum
values) and methods extracted from Schema.org
* Doctrine annotation mapping (database columns and relations)
* Data validation through [Symfony Validator](http://symfony.com/doc/current/book/validation.html) annotations
* `abstract` class and Doctrine inheritance support
* Interface and [Doctrine Resolve Target Entity Listener](http://doctrine-orm.readthedocs.org/en/latest/cookbook/resolve-target-entity-listener.html)
support
* Namespace support
* Enum generator relying on [PHP Enum](https://github.com/myclabs/php-enum)
* Fully configurable and extensible

## Installation

Use [Composer](http://getcomposer.org).

    composer create-project dunglas/php-schema.org-model

## Doctrine entity generator

Generates Doctrine entities from Schema.org vocables.

Usage:

    bin/schema my-output-directory/ [my-config.yml]

### Configuration

See [echoppe.yml](tests/config/echoppe.yml) file for a working example.
Without configuration file, the tool will build the entire Schema.org vocable.

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

# Generate interfaces and use Doctrine's Resolve Target Entity feature
interface:            true

# Use Doctrine's ArrayCollection instead of standard arrays
doctrineCollection:   true

# Emit a warning if a property is not derived from GoodRelations
checkIsGoodRelations:  false

# The Doctrine inheritance mapping type
inheritanceMapping:   '@ORM\Entity'

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

            # The Doctrine inheritance mapping type (override globally defined one)
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
    - SchemaOrgModel\AnnotationGenerator\DoctrineOrmAnnotationGenerator
```

## Cardinalities extractor

Extracts property's cardinality.
[GoodRelations](http://www.heppnetz.de/projects/goodrelations/) data are used when applicable. Other cardinalities are guessed using the property's comment.
When the cardinality cannot be automatically extracted, it's value is set to `unknown`.

Usage:

    php vendor/bin/schema.php schema:extract-cardinalities
