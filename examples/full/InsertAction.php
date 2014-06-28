<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Insert Action
 * 
 * @link http://schema.org/InsertAction
 * 
 * @ORM\MappedSuperclass
 */
class InsertAction extends AddAction
{
    /**
     * To Location
     * 
     * @var Place $toLocation A sub property of location. The final location of the object or the agent after the action.
     * 
     * @ORM\ManyToOne(targetEntity="Place")
     */
    private $toLocation;
}
