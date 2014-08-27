<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A service provided by a government organization, e.g. food stamps, veterans benefits, etc.
 * 
 * @see http://schema.org/GovernmentService Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class GovernmentService extends Service
{
    /**
     * @type Organization $serviceOperator The operating organization, if different from the provider.  This enables the representation of services that are provided by an organization, but operated by another organization like a subcontractor.
     * @ORM\ManyToOne(targetEntity="Organization")
     * @ORM\JoinColumn(nullable=false)
     */
    private $serviceOperator;
}
