<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Used to describe membership in a loyalty programs (e.g. "StarAliance"), traveler clubs (e.g. "AAA"), purchase clubs ("Safeway Club"), etc.
 * 
 * @see http://schema.org/ProgramMembership Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class ProgramMembership extends Intangible
{
    /**
     * @type Organization $member A member of an Organization or a ProgramMembership. Organizations can be members of organizations; ProgramMembership is typically for individuals.
     * @ORM\ManyToOne(targetEntity="Organization")
     */
    private $member;
    /**
     * @type string $membershipNumber A unique identifier for the membership.
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $membershipNumber;
    /**
     * @type string $programName The program providing the membership.
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $programName;
    /**
     * @type Organization $hostingOrganization The organization (airline, travelers' club, etc.) the membership is made with.
     * @ORM\ManyToOne(targetEntity="Organization")
     * @ORM\JoinColumn(nullable=false)
     */
    private $hostingOrganization;
}
