<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A contact point&#x2014;for example, a Customer Complaints department.
 * 
 * @see http://schema.org/ContactPoint Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class ContactPoint extends StructuredValue
{
    /**
     * @type AdministrativeArea $areaServed The location served by this contact point (e.g., a phone number intended for Europeans vs. North Americans or only within the United States.)
     * @ORM\ManyToOne(targetEntity="AdministrativeArea")
     * @ORM\JoinColumn(nullable=false)
     */
    private $areaServed;
    /**
     * @type Language $availableLanguage A language someone may use with the item.
     * @ORM\ManyToOne(targetEntity="Language")
     */
    private $availableLanguage;
    /**
     * @type ContactPointOption $contactOption An option available on this contact point (e.g. a toll-free number or support for hearing-impaired callers.)
     * @ORM\ManyToOne(targetEntity="ContactPointOption")
     */
    private $contactOption;
    /**
     * @type string $contactType A person or organization can have different contact points, for different purposes. For example, a sales contact point, a PR contact point and so on. This property is used to specify the kind of contact point.
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $contactType;
    /**
     * @type string $email Email address.
     * @Assert\Email
     * @ORM\Column
     */
    private $email;
    /**
     * @type string $faxNumber The fax number.
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $faxNumber;
    /**
     * @type OpeningHoursSpecification $hoursAvailable The hours during which this contact point is available.
     * @ORM\ManyToOne(targetEntity="OpeningHoursSpecification")
     * @ORM\JoinColumn(nullable=false)
     */
    private $hoursAvailable;
    /**
     * @type Product $productSupported The product or service this support contact point is related to (such as product support for a particular product line). This can be a specific product or product line (e.g. "iPhone") or a general category of products or services (e.g. "smartphones").
     * @ORM\ManyToOne(targetEntity="Product")
     * @ORM\JoinColumn(nullable=false)
     */
    private $productSupported;
    /**
     * @type string $telephone The telephone number.
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $telephone;
}
