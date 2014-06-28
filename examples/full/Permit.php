<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Permit
 * 
 * @link http://schema.org/Permit
 * 
 * @ORM\MappedSuperclass
 */
class Permit extends Intangible
{
    /**
     * Issued by
     * 
     * @var Organization $issuedBy The organization issuing the permit.
     * 
     * @ORM\ManyToOne(targetEntity="Organization")
     * @ORM\JoinColumn(nullable=false)
     */
    private $issuedBy;
    /**
     * Issued Through
     * 
     * @var Service $issuedThrough The service through with the permit was granted.
     * 
     * @ORM\ManyToOne(targetEntity="Service")
     * @ORM\JoinColumn(nullable=false)
     */
    private $issuedThrough;
    /**
     * Permit Audience
     * 
     * @var Audience $permitAudience The target audience for this permit.
     * 
     * @ORM\ManyToOne(targetEntity="Audience")
     * @ORM\JoinColumn(nullable=false)
     */
    private $permitAudience;
    /**
     * Valid for
     * 
     * @var Duration $validFor The time validity of the permit.
     * 
     * @ORM\ManyToOne(targetEntity="Duration")
     * @ORM\JoinColumn(nullable=false)
     */
    private $validFor;
    /**
     * Valid From
     * 
     * @var \DateTime $validFrom The date when the item becomes valid.
     * 
     * @Assert\DateTime
     * @ORM\Column(type="datetime")
     */
    private $validFrom;
    /**
     * Valid in
     * 
     * @var AdministrativeArea $validIn The geographic area where the permit is valid.
     * 
     * @ORM\ManyToOne(targetEntity="AdministrativeArea")
     * @ORM\JoinColumn(nullable=false)
     */
    private $validIn;
    /**
     * Valid Until
     * 
     * @var \DateTime $validUntil The date when the item is no longer valid.
     * 
     * @Assert\Date
     * @ORM\Column(type="date")
     */
    private $validUntil;
}
