# PHP Schema.org Model Scaffolding

This tool instantly generate a PHP data model from [Schema.org](http://schema.org) vocables. Browse Schema.org, choose
the types and properties you need, run our code generator and you're done! You get a fully featured PHP data model including:
* A set of PHP entities with properties, constants (enum values), getters, setters, adders and removers. The class
hierarchy provided by Schema.org will be translated to a PHP class hierarchy with parents as `abstract` classes. The generated
code complies with [PSR](http://www.php-fig.org/) coding standards.
* Full high-quality PHPDoc for classes, properties, constants and methods extracted from Schema.org.
* Doctrine ORM annotation mapping including database columns with type guessing, relations with cardinality guessing, class
inheritance (through the `@AbstractSuperclass` annotation).
* Data validation through [Symfony Validator](http://symfony.com/doc/current/book/validation.html) annotations including
data type validation, enum support (choices) and check for required properties.
* Interfaces and [Doctrine `ResolveTargetEntityListener`](http://doctrine-orm.readthedocs.org/en/latest/cookbook/resolve-target-entity-listener.html)
support.
* Custom PHP namespace support.
* List of values provided by Schema.org with [PHP Enum](https://github.com/myclabs/php-enum) classes.

Bonus:
* The code generator is fully configurable and extensible: all features can be deactivated (e.g.: the Doctrine mapping generator)
and custom generator can be added (e.g.: a Doctrine ODM mapping generator).
* The generated code can be used as is in a [Symfony](http://symfony.com) app (but it will work too in a raw PHP project
or any other framework including [Laravel](http://laravel.com) and [Zend Framework](http://framework.zend.com/)).

[![Build Status](https://travis-ci.org/dunglas/php-schema.svg?branch=master)](https://travis-ci.org/dunglas/php-schema) [![SensioLabsInsight](https://insight.sensiolabs.com/projects/87ec89e6-57cd-4ac0-9ab1-d4549c5425c5/mini.png)](https://insight.sensiolabs.com/projects/87ec89e6-57cd-4ac0-9ab1-d4549c5425c5)

## What is Schema.org?

Schema.org is a vocabulary representing common data structures and their relations. Schema.org can be exposed as [JSON-LD](http://en.wikipedia.org/wiki/JSON-LD),
[microdata](http://en.wikipedia.org/wiki/Microdata_(HTML)) and [RDFa](http://en.wikipedia.org/wiki/RDFa).
Extracting semantical data exposed in the Schema.org vocabulary is supported by a growing number of companies including
Google (Search, Gmail), Yahoo!, Bing and Yandex.

## Why use Schema.org data to generate a PHP model?

### Don't Reinvent The Wheel

Data models provided by Schema.org are popular and have been proved efficient. They cover a broad spectrum of topics including
creative work, e-commerce, event, medicine, social networking, people, postal address, organization, place or review.
Schema.org has its root in [a ton of preexisting well designed vocabularies](http://schema.rdfs.org/mappings.html) and is
successfully used by more and more website and applications.

Pick up schemas applicable to your application, generate your PHP model, then customize and specialize it to fit your needs.

### Improve SEO and user experience

Adding Schema.org markup to websites and apps increase their ranking in search engines results and enable awesome features
such as [Google Rich Snippets](https://support.google.com/webmasters/answer/99170?hl=en) and [Gmail markup](https://developers.google.com/gmail/markup/overview).

Mapping your app data model to Schema.org structures can be a tedious task. Using the generator, your data model will be
a derived from Schema.org. Adding microdata markup to your templates or serializing your data as JSON-LD will not require
specific mapping nor adaptation. It's a matter of minutes.

### Be ready for the future

Schema.org improves the interoperability of your applications. Used with hypermedia technologies such as [Hydra](http://www.hydra-cg.com/)
it's a big step towards the semantic and machine readable web.
It opens the way to generic web API clients able to extract and process data from any website or app using such technologies.

## Installation

Use [Composer](http://getcomposer.org) to install the generator. In standalone mode:

    composer create-project dunglas/php-schema

Or directly as a development dependency of your project:

    composer require --dev dunglas/php-schema

## Usage

Start by browsing [Schema.org](http://schema.org) and pick types applicable to your application. The website provides
tons of schemas including (but not limited too) representations of people, organization, event, postal address, creative
work and e-commerce structures.
Then, write a simple YAML config file like the following (here we will generate a data model for an address book):

`address-book.yml`:

```yml
# The PHP namespace of generated entities
namespaces:
  entity: "AddressBook\Entity"
# The list of types and properties we want to use
types:
  # Parent class of Person
  Thing:
    properties:
      name: ~
  Person:
    properties:
      familyName: ~
      givenName: ~
      additionalName: ~
      gender: ~
      address: ~
      birthDate: ~
      telephone: ~
      email: ~
      url: ~
      jobTitle: ~
  PostalAddress:
    # Disable the generation of the class hierarchy for this type
    parent: false
    properties:
      # Force the type of the addressCountry property to text
      addressCountry: { range: "Text" }
      addressLocality: ~
      addressRegion: ~
      postOfficeBoxNumber: ~
      postalCode: ~
      streetAddress: ~
```

Run the generator with this config file as parameter:

    bin/schema generate-types output-directory/ address-book.yml

The following classes will be generated:

`output-directory/AddressBook/Entity/Thing.php`:

```php
<?php


namespace AddressBook\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * The most generic type of item.
 *
 * @see http://schema.org/Thing Documentation on Schema.org
 *
 * @ORM\MappedSuperclass
 */
abstract class Thing
{
    /**
     * @var string $name The name of the item.
     * @Assert\Type(type="string")
     * @ORM\Column(nullable=true)
     */
    private $name;

    /**
     * Sets name.
     *
     * @param  string $name
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Gets name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
}

```

`output-directory/AddressBook/Entity/Person.php`:

```php
<?php


namespace AddressBook\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * A person (alive, dead, undead, or fictional).
 *
 * @see http://schema.org/Person Documentation on Schema.org
 *
 * @ORM\Entity
 */
class Person extends Thing
{
    /**
     * @var integer $id
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    /**
     * @var string $additionalName An additional name for a Person, can be used for a middle name.
     * @Assert\Type(type="string")
     * @ORM\Column(nullable=true)
     */
    private $additionalName;
    /**
     * @var PostalAddress $address Physical address of the item.
     * @ORM\ManyToOne(targetEntity="PostalAddress")
     */
    private $address;
    /**
     * @var \DateTime $birthDate Date of birth.
     * @Assert\Date
     * @ORM\Column(type="date", nullable=true)
     */
    private $birthDate;
    /**
     * @var string $email Email address.
     * @Assert\Email
     * @ORM\Column(nullable=true)
     */
    private $email;
    /**
     * @var string $familyName Family name. In the U.S., the last name of an Person. This can be used along with givenName instead of the name property.
     * @Assert\Type(type="string")
     * @ORM\Column(nullable=true)
     */
    private $familyName;
    /**
     * @var string $gender Gender of the person.
     * @Assert\Type(type="string")
     * @ORM\Column(nullable=true)
     */
    private $gender;
    /**
     * @var string $givenName Given name. In the U.S., the first name of a Person. This can be used along with familyName instead of the name property.
     * @Assert\Type(type="string")
     * @ORM\Column(nullable=true)
     */
    private $givenName;
    /**
     * @var string $jobTitle The job title of the person (for example, Financial Manager).
     * @Assert\Type(type="string")
     * @ORM\Column(nullable=true)
     */
    private $jobTitle;
    /**
     * @var string $telephone The telephone number.
     * @Assert\Type(type="string")
     * @ORM\Column(nullable=true)
     */
    private $telephone;

    /**
     * Sets id.
     *
     * @param  integer $id
     * @return $this
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Gets id.
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Sets additionalName.
     *
     * @param  string $additionalName
     * @return $this
     */
    public function setAdditionalName($additionalName)
    {
        $this->additionalName = $additionalName;

        return $this;
    }

    /**
     * Gets additionalName.
     *
     * @return string
     */
    public function getAdditionalName()
    {
        return $this->additionalName;
    }

    /**
     * Sets address.
     *
     * @param  PostalAddress $address
     * @return $this
     */
    public function setAddress(PostalAddress $address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Gets address.
     *
     * @return PostalAddress
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Sets birthDate.
     *
     * @param  \DateTime $birthDate
     * @return $this
     */
    public function setBirthDate(\DateTime $birthDate)
    {
        $this->birthDate = $birthDate;

        return $this;
    }

    /**
     * Gets birthDate.
     *
     * @return \DateTime
     */
    public function getBirthDate()
    {
        return $this->birthDate;
    }

    /**
     * Sets email.
     *
     * @param  string $email
     * @return $this
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Gets email.
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Sets familyName.
     *
     * @param  string $familyName
     * @return $this
     */
    public function setFamilyName($familyName)
    {
        $this->familyName = $familyName;

        return $this;
    }

    /**
     * Gets familyName.
     *
     * @return string
     */
    public function getFamilyName()
    {
        return $this->familyName;
    }

    /**
     * Sets gender.
     *
     * @param  string $gender
     * @return $this
     */
    public function setGender($gender)
    {
        $this->gender = $gender;

        return $this;
    }

    /**
     * Gets gender.
     *
     * @return string
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * Sets givenName.
     *
     * @param  string $givenName
     * @return $this
     */
    public function setGivenName($givenName)
    {
        $this->givenName = $givenName;

        return $this;
    }

    /**
     * Gets givenName.
     *
     * @return string
     */
    public function getGivenName()
    {
        return $this->givenName;
    }

    /**
     * Sets jobTitle.
     *
     * @param  string $jobTitle
     * @return $this
     */
    public function setJobTitle($jobTitle)
    {
        $this->jobTitle = $jobTitle;

        return $this;
    }

    /**
     * Gets jobTitle.
     *
     * @return string
     */
    public function getJobTitle()
    {
        return $this->jobTitle;
    }

    /**
     * Sets telephone.
     *
     * @param  string $telephone
     * @return $this
     */
    public function setTelephone($telephone)
    {
        $this->telephone = $telephone;

        return $this;
    }

    /**
     * Gets telephone.
     *
     * @return string
     */
    public function getTelephone()
    {
        return $this->telephone;
    }
}

```

`output-directory/AddressBook/Entity/PostalAddress.php`:

```php
<?php


namespace AddressBook\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * The mailing address.
 *
 * @see http://schema.org/PostalAddress Documentation on Schema.org
 *
 * @ORM\Entity
 */
class PostalAddress
{
    /**
     * @var integer $id
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    /**
     * @var string $addressCountry The country. For example, USA. You can also provide the two-letter [ISO 3166-1 alpha-2 country code](http://en.wikipedia.org/wiki/ISO_3166-1).
     * @Assert\Type(type="string")
     * @ORM\Column(nullable=true)
     */
    private $addressCountry;
    /**
     * @var string $addressLocality The locality. For example, Mountain View.
     * @Assert\Type(type="string")
     * @ORM\Column(nullable=true)
     */
    private $addressLocality;
    /**
     * @var string $addressRegion The region. For example, CA.
     * @Assert\Type(type="string")
     * @ORM\Column(nullable=true)
     */
    private $addressRegion;
    /**
     * @var string $postalCode The postal code. For example, 94043.
     * @Assert\Type(type="string")
     * @ORM\Column(nullable=true)
     */
    private $postalCode;
    /**
     * @var string $postOfficeBoxNumber The post office box number for PO box addresses.
     * @Assert\Type(type="string")
     * @ORM\Column(nullable=true)
     */
    private $postOfficeBoxNumber;
    /**
     * @var string $streetAddress The street address. For example, 1600 Amphitheatre Pkwy.
     * @Assert\Type(type="string")
     * @ORM\Column(nullable=true)
     */
    private $streetAddress;

    /**
     * Sets id.
     *
     * @param  integer $id
     * @return $this
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Gets id.
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Sets addressCountry.
     *
     * @param  string $addressCountry
     * @return $this
     */
    public function setAddressCountry($addressCountry)
    {
        $this->addressCountry = $addressCountry;

        return $this;
    }

    /**
     * Gets addressCountry.
     *
     * @return string
     */
    public function getAddressCountry()
    {
        return $this->addressCountry;
    }

    /**
     * Sets addressLocality.
     *
     * @param  string $addressLocality
     * @return $this
     */
    public function setAddressLocality($addressLocality)
    {
        $this->addressLocality = $addressLocality;

        return $this;
    }

    /**
     * Gets addressLocality.
     *
     * @return string
     */
    public function getAddressLocality()
    {
        return $this->addressLocality;
    }

    /**
     * Sets addressRegion.
     *
     * @param  string $addressRegion
     * @return $this
     */
    public function setAddressRegion($addressRegion)
    {
        $this->addressRegion = $addressRegion;

        return $this;
    }

    /**
     * Gets addressRegion.
     *
     * @return string
     */
    public function getAddressRegion()
    {
        return $this->addressRegion;
    }

    /**
     * Sets postalCode.
     *
     * @param  string $postalCode
     * @return $this
     */
    public function setPostalCode($postalCode)
    {
        $this->postalCode = $postalCode;

        return $this;
    }

    /**
     * Gets postalCode.
     *
     * @return string
     */
    public function getPostalCode()
    {
        return $this->postalCode;
    }

    /**
     * Sets postOfficeBoxNumber.
     *
     * @param  string $postOfficeBoxNumber
     * @return $this
     */
    public function setPostOfficeBoxNumber($postOfficeBoxNumber)
    {
        $this->postOfficeBoxNumber = $postOfficeBoxNumber;

        return $this;
    }

    /**
     * Gets postOfficeBoxNumber.
     *
     * @return string
     */
    public function getPostOfficeBoxNumber()
    {
        return $this->postOfficeBoxNumber;
    }

    /**
     * Sets streetAddress.
     *
     * @param  string $streetAddress
     * @return $this
     */
    public function setStreetAddress($streetAddress)
    {
        $this->streetAddress = $streetAddress;

        return $this;
    }

    /**
     * Gets streetAddress.
     *
     * @return string
     */
    public function getStreetAddress()
    {
        return $this->streetAddress;
    }
}

```

Note that the generator take care of creating directories corresponding to the namespace structure.

Without configuration file, the tool will build the entire Schema.org vocable. If no properties are specified for a given
type, all its properties will be generated.

The generator also support enumerations generation. For subclasses of `[Enumeration](https://schema.org/Enumeration)`, the
generator will automatically create a class extending the Enum type provided by [myclabs/php-enum](https://github.com/myclabs/php-enum).
Don't forget to install this library in your project. Refer you to PHP Enum documentation to see how to use it. The Symfony
validation annotation generator automatically takes care of enumerations to validate choices values.

A config file generating an enum class:

```yml
types:
  OfferItemCondition: ~ # The generator will automatically guess that OfferItemCondition is subclass of Enum
```

The associated PHP class:

```php
<?php


namespace SchemaOrg\Enum;

use MyCLabs\Enum\Enum;

/**
 * A list of possible conditions for the item.
 *
 * @see http://schema.org/OfferItemCondition Documentation on Schema.org
 */
class OfferItemCondition extends Enum
{
    /**
     * @type string DamagedCondition
     */
    const DAMAGED_CONDITION = 'http://schema.org/DamagedCondition';
    /**
     * @type string NewCondition
     */
    const NEW_CONDITION = 'http://schema.org/NewCondition';
    /**
     * @type string RefurbishedCondition
     */
    const REFURBISHED_CONDITION = 'http://schema.org/RefurbishedCondition';
    /**
     * @type string UsedCondition
     */
    const USED_CONDITION = 'http://schema.org/UsedCondition';
}

```

See [ecommerce.yml](tests/config/ecommerce.yml) for a complexer example.

## Settings

The following options can be used in the configuration file.

### Customizing PHP namespaces

Namespaces of generated PHP classes can be set globally, respectively for entities, enumerations and interfaces (if used
with Doctrine Resolve Target Entity Listener option).

Example:

```yml
namespaces:
  entity:               "Dunglas\EcommerceBundle\Entity"
  enum:                 "Dunglas\EcommerceBundle\Enum"
  interface:            "Dunglas\EcommerceBundle\Model"
```

Namespaces can also be specified for a specific type. It will take precedence over any globally configured namespace.

Example:

```yml
types:
  Thing:
    namespaces:
      entity: "Dunglas\CoreBundle\Entity" # Namespace for the Thing entity (works for enumerations too)
      interface: "Schema\Model" # Namespace of the related interface
```

### Forcing a field range

Schema.org allows a property to have several types. However, the generator allows only one type by property. If not configured,
it will use the first defined type.
The `range` option is useful to set the type of a given property. It can also be used to force a type (even if not in the
Schema.org definition).

Example:

```yml
types:
  Brand:
    properties:
      logo: { range: "ImageObject" } # Force the range of the logo propery to ImageObject (can also be URL according to Schema.org)

  PostalAddress:
    properties:
      addressCountry: { range: "Text" } # Force the type to Text instead of Country
```

### Forcing a field cardinality

The cardinality of a property is automatically guessed. The `cardinality` option allows to override the guessed value.
Supported cardinalities are:
* `(0..1)`: scalar, not required
* `(0..*)`: array, not required
* `(1..1)`: scalar, required
* `(1..*)`: array, required

Cardinalities are enforced by the class generator, the Doctrine ORM generator and the Symfony validation generator.

Example:

```yml
types:
  Product:
    properties:
      sku:
        cardinality: "(0..1)"
```

### Forcing (or disabling) a class parent

Override the guessed class hierarchy of a given type with this option.

Example:

```yml
  ImageObject:
    parent: Thing # Force the parent to be Thing instead of CreativeWork > MediaObject
    properties: ~
  Drug:
    parent: false # No parent
```

### Author PHPDoc

Add a `@author` PHPDoc annotation to class' DocBlock.

Example:

```yml
author: "Kévin Dunglas <kevin@les-tilleuls.coop>"
```

### Disabling generators and creating custom ones

By default, all generators are enabled. You can specify the list of generators to use with the `generators` option.

Example (enabling only the PHPDoc generator):

```yml
annotationGenerators:
    - SchemaOrgModel\AnnotationGenerator\PhpDocAnnotationGenerator
```

You can write your generators by implementing the [AnnotationGeneratorInterface](src/SchemaOrgModel/AnnotationGenerator/AnnotationGeneratorInterface).
The [AbstractAnnotationGenerator](src/SchemaOrgModel/AnnotationGenerator/AbstractAnnotationGenerator) provides helper methods
useful when creating your own generators.

Enabling a custom generator and the PHPDoc generator:

```yml
annotationGenerators:
  - SchemaOrgModel\AnnotationGenerator\PhpDocAnnotationGenerator
  - Acme\Generators\MyGenerator
```

### Disabling `id` generator

By default, the generator add a property called `id` not provided by Schema.org. This useful when using generated entity
with an ORM or an ODM.
This behavior can be disabled with the following setting:

```yml
generateId: false
```

### Disabling usage of Doctrine collection

By default, the generator use classes provided by the [Doctrine Collections](https://github.com/doctrine/collections) library
to store collections of entities. This is useful (and required) when using Doctrine ORM or Doctrine ODM.
This behavior can be disabled (to fallback to standard arrays) with the following setting:

```yml
useDoctrineCollection: false
```

### Custom field visibility

Generated fields have a `private` visibility and are exposed through getters and setters.
The default visibility can be changed with the `fieldVisibility` otion.

Example:

```yml
fieldVisibility: "protected"
```

### Forcing Doctrine inheritance mapping annotation

The standard behavior of the generator is to use the `@MappedSuperclass` Doctrine annotation for classes with children and
`@Entity` for classes with no child.

The inheritance annotation can be forced for a given type like the following:

```yml
types:
  Product:
    doctrine:
      inheritanceMapping: "@MappedSuperclass"
```

*This setting is only relevant when using the Doctrine ORM generator.*

### Interfaces and Doctrine Resolve Target Entity Listener

[`ResolveTargetEntityListener`](http://doctrine-orm.readthedocs.org/en/latest/cookbook/resolve-target-entity-listener.html)
is a feature of Doctrine to keep modules independent. It allows to specify interfaces and `abstract` classes in relation
mappings.

If you set the option `useInterface` to true, the generator will generate an interface corresponding to each generated
entity and will use them in relation mappings.


### Custom schemas

The generator can use your own schema definitions. They must be wrote in RDFa and follow the format of the [Schema.org's
definition](http://schema.org/docs/schema_org_rdfa.html). This is useful to document your [Schema.org extensions](http://schema.org/docs/extension.html) and use them
to generate the PHP data model of your application.

Example:

```yml
rdfa:
  - https://raw.githubusercontent.com/rvguha/schemaorg/master/data/schema.rdfa # Experimental version of Schema.org
  - http://example.com/data/myschema.rfa # Additional types
```

*Support for other namespaces than `http://schema.org` is planned for future versions but not currently available.*

### Enabling PSR-5 PHPDoc support

Set the `useType` option to `true` and the generator will use the `@type` annotation (defined in ([PSR-5](https://github.com/php-fig/fig-standards/pull/169))
instead of the traditional `@var`.

*The current status of PSR-5 is draft and is still subject to major modifications.*

### Checking GoodRelation compatibility

If the `checkIsGoodRelations` option is set to `true`, the generator will emit a warning if an encountered property is not
par of the [GoodRelations](http://www.heppnetz.de/projects/goodrelations/) schema.

This is useful when generating e-commerce data model.

### PHP file header

Prepend all generated PHP files with a custom comment.

Example:

```yml
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
    - https://raw.githubusercontent.com/rvguha/schemaorg/master/data/schema.rdfa

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

# Use PSR-5's @type annotation instead of @var in the PHPDoc
useType:              false

# Use Doctrine's ArrayCollection instead of standard arrays
useDoctrineCollection:  true

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

## Cardinality extractor

The Cardinality Extractor is a standalone tool (also used internally by the generator) extracting property's cardinality.
Its uses [GoodRelations](http://www.heppnetz.de/projects/goodrelations/) data when available. Other cardinalities are
guessed using the property's comment.
When the cardinality cannot be automatically extracted, it's value is set to `unknown`.

Usage:

    bin/schema extract-cardinalities

## Credits

This project has been created by [Kévin Dunglas](http://dunglas.fr) and is sponsored by [Les-Tilleuls.coop](http://les-tilleuls.coop).
