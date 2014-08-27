<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A structured value providing information about when a certain organization or person owned a certain product.
 * 
 * @see http://schema.org/OwnershipInfo Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class OwnershipInfo extends StructuredValue
{
    /**
     * @type Organization $acquiredFrom The organization or person from which the product was acquired.
     * @ORM\ManyToOne(targetEntity="Organization")
     * @ORM\JoinColumn(nullable=false)
     */
    private $acquiredFrom;
    /**
     * @type \DateTime $ownedFrom The date and time of obtaining the product.
     * @Assert\DateTime
     * @ORM\Column(type="datetime")
     */
    private $ownedFrom;
    /**
     * @type \DateTime $ownedThrough The date and time of giving up ownership on the product.
     * @Assert\DateTime
     * @ORM\Column(type="datetime")
     */
    private $ownedThrough;
    /**
     * @type Product $typeOfGood The product that this structured value is referring to.
     * @ORM\OneToOne(targetEntity="Product")
     * @ORM\JoinColumn(nullable=false)
     */
    private $typeOfGood;
}
