<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Postal Address
 * 
 * @link http://schema.org/PostalAddress
 * 
 * @ORM\Entity
 */
class PostalAddress extends ContactPoint
{
    /**
     * Address Country
     * 
     * @var Country $addressCountry The country. For example, USA. You can also provide the two-letter ISO 3166-1 alpha-2 country code.
     * 
     * @ORM\ManyToOne(targetEntity="Country")
     * @ORM\JoinColumn(nullable=false)
     */
    private $addressCountry;
    /**
     * Address Locality
     * 
     * @var string $addressLocality The locality. For example, Mountain View.
     * 
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $addressLocality;
    /**
     * Address Region
     * 
     * @var string $addressRegion The region. For example, CA.
     * 
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $addressRegion;
    /**
     * Postal Code
     * 
     * @var string $postalCode The postal code. For example, 94043.
     * 
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $postalCode;
    /**
     * Post Office Box Number
     * 
     * @var string $postOfficeBoxNumber The post offce box number for PO box addresses.
     * 
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $postOfficeBoxNumber;
    /**
     * Street Address
     * 
     * @var string $streetAddress The street address. For example, 1600 Amphitheatre Pkwy.
     * 
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $streetAddress;
}
