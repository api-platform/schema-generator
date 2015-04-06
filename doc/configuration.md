# Configuration

The following options can be used in the configuration file.

## Customizing PHP namespaces

Namespaces of generated PHP classes can be set globally, respectively for entities, enumerations and interfaces (if used
with Doctrine Resolve Target Entity Listener option).

Example:

```yaml
namespaces:
  entity:               "Dunglas\EcommerceBundle\Entity"
  enum:                 "Dunglas\EcommerceBundle\Enum"
  interface:            "Dunglas\EcommerceBundle\Model"
```

Namespaces can also be specified for a specific type. It will take precedence over any globally configured namespace.

Example:

```yaml
types:
  Thing:
    namespaces:
      entity: "Dunglas\CoreBundle\Entity" # Namespace for the Thing entity (works for enumerations too)
      interface: "Schema\Model" # Namespace of the related interface
```

## Forcing a field range

Schema.org allows a property to have several types. However, the generator allows only one type by property. If not configured,
it will use the first defined type.
The `range` option is useful to set the type of a given property. It can also be used to force a type (even if not in the
Schema.org definition).

Example:

```yaml
types:
  Brand:
    properties:
      logo: { range: "ImageObject" } # Force the range of the logo propery to ImageObject (can also be URL according to Schema.org)

  PostalAddress:
    properties:
      addressCountry: { range: "Text" } # Force the type to Text instead of Country
```

## Forcing a field cardinality

The cardinality of a property is automatically guessed. The `cardinality` option allows to override the guessed value.
Supported cardinalities are:
* `(0..1)`: scalar, not required
* `(0..*)`: array, not required
* `(1..1)`: scalar, required
* `(1..*)`: array, required

Cardinalities are enforced by the class generator, the Doctrine ORM generator and the Symfony validation generator.

Example:

```yaml
types:
  Product:
    properties:
      sku:
        cardinality: "(0..1)"
```

## Forcing (or disabling) a class parent

Override the guessed class hierarchy of a given type with this option.

Example:

```yaml
  ImageObject:
    parent: Thing # Force the parent to be Thing instead of CreativeWork > MediaObject
    properties: ~
  Drug:
    parent: false # No parent
```

## Forcing a class to be abstract

Force a class to be `abstract` (or to be not).

Example:

```yaml
   Person:
     abstract: true
```

## Author PHPDoc

Add a `@author` PHPDoc annotation to class' DocBlock.

Example:

```yaml
author: "Kévin Dunglas <kevin@les-tilleuls.coop>"
```

## Disabling generators and creating custom ones

By default, all generators except the `DunglasJsonLdApi` one are enabled. You can specify the list of generators to use
with the `generators` option.

Example (enabling only the PHPDoc generator):

```yaml
annotationGenerators:
    - SchemaOrgModel\AnnotationGenerator\PhpDocAnnotationGenerator
```

You can write your generators by implementing the [AnnotationGeneratorInterface](src/SchemaOrgModel/AnnotationGenerator/AnnotationGeneratorInterface).
The [AbstractAnnotationGenerator](src/SchemaOrgModel/AnnotationGenerator/AbstractAnnotationGenerator) provides helper methods
useful when creating your own generators.

Enabling a custom generator and the PHPDoc generator:

```yaml
annotationGenerators:
  - SchemaOrgModel\AnnotationGenerator\PhpDocAnnotationGenerator
  - Acme\Generators\MyGenerator
```

## Disabling `id` generator

By default, the generator add a property called `id` not provided by Schema.org. This useful when using generated entity
with an ORM or an ODM.
This behavior can be disabled with the following setting:

```yaml
generateId: false
```

## Disabling usage of Doctrine collection

By default, the generator use classes provided by the [Doctrine Collections](https://github.com/doctrine/collections) library
to store collections of entities. This is useful (and required) when using Doctrine ORM or Doctrine ODM.
This behavior can be disabled (to fallback to standard arrays) with the following setting:

```yaml
doctrine:
  useCollection: false
```

## Custom field visibility

Generated fields have a `private` visibility and are exposed through getters and setters.
The default visibility can be changed with the `fieldVisibility` otion.

Example:

```yaml
fieldVisibility: "protected"
```

## Forcing Doctrine inheritance mapping annotation

The standard behavior of the generator is to use the `@MappedSuperclass` Doctrine annotation for classes with children and
`@Entity` for classes with no child.

The inheritance annotation can be forced for a given type like the following:

```yaml
types:
  Product:
    doctrine:
      inheritanceMapping: "@MappedSuperclass"
```

*This setting is only relevant when using the Doctrine ORM generator.*

## Interfaces and Doctrine Resolve Target Entity Listener

[`ResolveTargetEntityListener`](http://doctrine-orm.readthedocs.org/en/latest/cookbook/resolve-target-entity-listener.html)
is a feature of Doctrine to keep modules independent. It allows to specify interfaces and `abstract` classes in relation
mappings.

If you set the option `useInterface` to true, the generator will generate an interface corresponding to each generated
entity and will use them in relation mappings.

To let PHP Schema generating the XML mapping file usable with Symfony add the following to your config file:

```yaml
doctrine:
  resolveTargetEntityConfigPath: path/to/doctrine.xml
```

## Custom schemas

The generator can use your own schema definitions. They must be wrote in RDFa and follow the format of the [Schema.org's
definition](http://schema.org/docs/schema_org_rdfa.html). This is useful to document your [Schema.org extensions](http://schema.org/docs/extension.html) and use them
to generate the PHP data model of your application.

Example:

```yaml
rdfa:
  - https://raw.githubusercontent.com/rvguha/schemaorg/master/data/schema.rdfa # Experimental version of Schema.org
  - http://example.com/data/myschema.rfa # Additional types
```

*Support for other namespaces than `http://schema.org` is planned for future versions but not currently available.*

## Checking GoodRelation compatibility

If the `checkIsGoodRelations` option is set to `true`, the generator will emit a warning if an encountered property is not
par of the [GoodRelations](http://www.heppnetz.de/projects/goodrelations/) schema.

This is useful when generating e-commerce data model.

## PHP file header

Prepend all generated PHP files with a custom comment.

Example:

```yaml
header: |
  /*
   * This file is part of the Ecommerce package.
   *
   * (c) Kévin Dunglas <dunglas@gmail.com>
   *
   * For the full copyright and license information, please view the LICENSE
   * file that was distributed with this source code.
   */
```


## Full configuration reference

```yaml
# RDFa files to use
rdfa:

    # Default:
    - http://schema.org/docs/schema_org_rdfa.html

# OWL relation files to use
relations:

    # Default:
    - http://purl.org/goodrelations/v1.owl

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
    entity:               SchemaOrg\Entity # Example: Acme\Entity

    # The namespace of the generated enumerations
    enum:                 SchemaOrg\Enum # Example: Acme\Enum

    # The namespace of the generated interfaces
    interface:            SchemaOrg\Model # Example: Acme\Model

# Doctrine
doctrine:

    # Use Doctrine's ArrayCollection instead of standard arrays
    useCollection:        true

    # The Resolve Target Entity Listener config file pass
    resolveTargetEntityConfigPath:  null

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

            # The Doctrine inheritance mapping type (override the guessed one)
            inheritanceMapping:   null

        # The parent class, set to false for a top level class
        parent:               null

        # Properties of this type to use
        properties:

            # Prototype
            id:

                # The property range
                range:                null # Example: Offer
                cardinality:          ~ # One of "(0..1)"; "(0..*)"; "(1..1)"; "(1..*)"; "unknown"

# Annotation generators to use
annotationGenerators:

    # Defaults:
    - SchemaOrgModel\AnnotationGenerator\PhpDocAnnotationGenerator
    - SchemaOrgModel\AnnotationGenerator\ConstraintAnnotationGenerator
    - SchemaOrgModel\AnnotationGenerator\DoctrineOrmAnnotationGenerator
```