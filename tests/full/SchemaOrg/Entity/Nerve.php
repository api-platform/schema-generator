<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A common pathway for the electrochemical nerve impulses that are transmitted along each of the axons.
 * 
 * @see http://schema.org/Nerve Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class Nerve extends AnatomicalStructure
{
    /**
     */
    private $branch;
    /**
     */
    private $nerveMotor;
    /**
     */
    private $sensoryUnit;
    /**
     */
    private $sourcedFrom;
}
