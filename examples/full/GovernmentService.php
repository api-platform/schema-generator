<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Government Service
 * 
 * @link http://schema.org/GovernmentService
 * 
 * @ORM\Entity
 */
class GovernmentService extends Service
{
    /**
     * Service Operator
     * 
     * @var Organization $serviceOperator The operating organization, if different from the provider.  This enables the representation of services that are provided by an organization, but operated by another organization like a subcontractor.
     * 
     * @ORM\ManyToOne(targetEntity="Organization")
     * @ORM\JoinColumn(nullable=false)
     */
    private $serviceOperator;
}
