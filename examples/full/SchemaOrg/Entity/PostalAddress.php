<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * The mailing address.
 * 
 * @see http://schema.org/PostalAddress Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class PostalAddress extends ContactPoint
{
    /**
     * @type Country $addressCountry The country. For example, USA. You can also provide the two-letter <a href='http://en.wikipedia.org/wiki/ISO_3166-1'>ISO 3166-1 alpha-2 country code</a>.
     * @ORM\ManyToOne(targetEntity="Country")
     * @ORM\JoinColumn(nullable=false)
     */
    private $addressCountry;
    /**
     * @type string $addressLocality The locality. For example, Mountain View.
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $addressLocality;
    /**
     * @type string $addressRegion The region. For example, CA.
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $addressRegion;
    /**
     * @type string $postalCode The postal code. For example, 94043.
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $postalCode;
    /**
     * @type string $postOfficeBoxNumber The post office box number for PO box addresses.
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $postOfficeBoxNumber;
    /**
     * @type string $streetAddress The street address. For example, 1600 Amphitheatre Pkwy.
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $streetAddress;
}
