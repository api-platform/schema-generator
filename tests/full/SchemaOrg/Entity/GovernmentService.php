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
     */
    private $serviceOperator;
}
