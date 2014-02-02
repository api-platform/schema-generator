# PHP Schema.org Model

Various tools to generate a data model based on [Schema.org](http://schema.org) vocables.

*This project is a work in progress. It is not finished yet.*

[![Build Status](https://travis-ci.org/dunglas/php-schema.org-model.png?branch=master)](https://travis-ci.org/dunglas/php-schema.org-model)


## Installation

Use [Composer](http://getcomposer.org).

    composer require dunglas/php-schema.org-model

## Doctrine entities generator

Generates Doctrine entities from Schema.org vocables.

Usage:

    php vendor/bin/schema.php my-output-directory/ [config.yml]

### Configuration

See [lechoppe.yml](examples/config/lechoppe.yml) file.

### Configuration reference

```yaml
# Debug mode
debug:                false

# Emit a warning if a property is not derived from GoodRelations
check_is_goodrelations:  false

# A license or any text to use as header of generated files
header:               false # Example: // (c) Kévin Dunglas <dunglas@gmail.com>

# The namespace of the generated files
namespace:            SchemaOrg # Example: SchemaOrgModel

# The value of the phpDoc's @author annotation
author:               false # Example: Kévin Dunglas <dunglas@gmail.com>

# Visibility of entities fields
field_visibility:     ~ # One of "private"; "protected"; "public"

# Schema.org's types to use
types:

    # Prototype
    id:

        # Properties of this type to use
        properties:           []
```

## Cardinalities extractor

Extracts property's cardinality.
[GoodRelations](http://www.heppnetz.de/projects/goodrelations/) data are used when applicable. Other cardinalities are guessed using the property's comment.
When the cardinality cannot be automatically extracted, it's value is set to `unknown`.

Usage:

    php vendor/bin/schema.php schema:extract-cardinalities

