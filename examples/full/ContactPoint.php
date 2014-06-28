<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Contact Point
 * 
 * @link http://schema.org/ContactPoint
 * 
 * @ORM\MappedSuperclass
 */
class ContactPoint extends StructuredValue
{
    /**
     * Area Served
     * 
     * @var AdministrativeArea $areaServed The location served by this contact point (e.g., a phone number intended for Europeans vs. North Americans or only within the United States.)
     * 
     * @ORM\ManyToOne(targetEntity="AdministrativeArea")
     * @ORM\JoinColumn(nullable=false)
     */
    private $areaServed;
    /**
     * Available Language
     * 
     * @var Language $availableLanguage A language someone may use with the item.
     * 
     * @ORM\ManyToOne(targetEntity="Language")
     */
    private $availableLanguage;
    /**
     * Contact Option
     * 
     * @var ContactPointOption $contactOption An option available on this contact point (e.g. a toll-free number or support for hearing-impaired callers.)
     * 
     * @ORM\ManyToOne(targetEntity="ContactPointOption")
     */
    private $contactOption;
    /**
     * Contact Type
     * 
     * @var string $contactType A person or organization can have different contact points, for different purposes. For example, a sales contact point, a PR contact point and so on. This property is used to specify the kind of contact point.
     * 
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $contactType;
    /**
     * Email
     * 
     * @var string $email Email address.
     * 
     * @Assert\Email
     * @ORM\Column
     */
    private $email;
    /**
     * Fax Number
     * 
     * @var string $faxNumber The fax number.
     * 
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $faxNumber;
    /**
     * Hours Available
     * 
     * @var OpeningHoursSpecification $hoursAvailable The hours during which this contact point is available.
     * 
     * @ORM\ManyToOne(targetEntity="OpeningHoursSpecification")
     * @ORM\JoinColumn(nullable=false)
     */
    private $hoursAvailable;
    /**
     * Product Supported
     * 
     * @var Product $productSupported The product or service this support contact point is related to (such as product support for a particular product line). This can be a specific product or product line (e.g. "iPhone") or a general category of products or services (e.g. "smartphones").
     * 
     * @ORM\ManyToOne(targetEntity="Product")
     * @ORM\JoinColumn(nullable=false)
     */
    private $productSupported;
    /**
     * Telephone
     * 
     * @var string $telephone The telephone number.
     * 
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $telephone;
}
