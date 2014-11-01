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
     */
    private $member;
    /**
     */
    private $membershipNumber;
    /**
     */
    private $programName;
    /**
     */
    private $hostingOrganization;
}
