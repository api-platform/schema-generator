<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A delivery service through which content is provided via broadcast over the air or online.
 * 
 * @see http://schema.org/BroadcastService Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class BroadcastService extends Thing
{
    /**
     */
    private $area;
    /**
     */
    private $broadcaster;
    /**
     */
    private $parentService;
}
