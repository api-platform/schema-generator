<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A permit issued by an organization, e.g. a parking pass.
 * 
 * @see http://schema.org/Permit Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class Permit extends Intangible
{
    /**
     * @type Service $issuedThrough The service through with the permit was granted.
     * @ORM\ManyToOne(targetEntity="Service")
     * @ORM\JoinColumn(nullable=false)
     */
    private $issuedThrough;
    /**
     * @type Audience $permitAudience The target audience for this permit.
     * @ORM\ManyToOne(targetEntity="Audience")
     * @ORM\JoinColumn(nullable=false)
     */
    private $permitAudience;
    /**
     * @type Duration $validFor The time validity of the permit.
     * @ORM\ManyToOne(targetEntity="Duration")
     * @ORM\JoinColumn(nullable=false)
     */
    private $validFor;
    /**
     * @type \DateTime $validFrom The date when the item becomes valid.
     * @Assert\DateTime
     * @ORM\Column(type="datetime")
     */
    private $validFrom;
    /**
     * @type AdministrativeArea $validIn The geographic area where the permit is valid.
     * @ORM\ManyToOne(targetEntity="AdministrativeArea")
     * @ORM\JoinColumn(nullable=false)
     */
    private $validIn;
    /**
     * @type \DateTime $validUntil The date when the item is no longer valid.
     * @Assert\Date
     * @ORM\Column(type="date")
     */
    private $validUntil;
    /**
     * @type Organization $issuedBy The organization issuing the ticket or permit.
     * @ORM\ManyToOne(targetEntity="Organization")
     * @ORM\JoinColumn(nullable=false)
     */
    private $issuedBy;
}
