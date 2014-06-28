<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Ownership Info
 * 
 * @link http://schema.org/OwnershipInfo
 * 
 * @ORM\Entity
 */
class OwnershipInfo extends StructuredValue
{
    /**
     * Acquired From
     * 
     * @var Organization $acquiredFrom The organization or person from which the product was acquired.
     * 
     * @ORM\ManyToOne(targetEntity="Organization")
     * @ORM\JoinColumn(nullable=false)
     */
    private $acquiredFrom;
    /**
     * Owned From
     * 
     * @var \DateTime $ownedFrom The date and time of obtaining the product.
     * 
     * @Assert\DateTime
     * @ORM\Column(type="datetime")
     */
    private $ownedFrom;
    /**
     * Owned Through
     * 
     * @var \DateTime $ownedThrough The date and time of giving up ownership on the product.
     * 
     * @Assert\DateTime
     * @ORM\Column(type="datetime")
     */
    private $ownedThrough;
    /**
     * Type of Good
     * 
     * @var Product $typeOfGood The product that this structured value is referring to.
     * 
     * @ORM\OneToOne(targetEntity="Product")
     * @ORM\JoinColumn(nullable=false)
     */
    private $typeOfGood;
}
