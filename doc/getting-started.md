# Usage

## Installation

Use [Composer](http://getcomposer.org) to install the generator. In standalone mode:

    composer create-project dunglas/php-schema

Or directly as a development dependency of your project:

    composer require --dev dunglas/php-schema

## Model scaffolding

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

Without configuration file, the tool will build the entire Schema.org vocabulary. If no properties are specified for a given
type, all its properties will be generated.

The generator also support enumerations generation. For subclasses of [`Enumeration`](https://schema.org/Enumeration), the
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

### Going further

* Browse [the configuration documentation](configuration.md)
* See `tests/config/ecommerce.yml`

## Cardinality extraction

The Cardinality Extractor is a standalone tool (also used internally by the generator) extracting property's cardinality.
Its uses [GoodRelations](http://www.heppnetz.de/projects/goodrelations/) data when available. Other cardinalities are
guessed using the property's comment.
When the cardinality cannot be automatically extracted, it's value is set to `unknown`.

Usage:

    bin/schema extract-cardinalities
