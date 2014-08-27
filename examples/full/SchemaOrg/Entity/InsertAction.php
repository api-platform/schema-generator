<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * The act of adding at a specific location in an ordered collection.
 * 
 * @see http://schema.org/InsertAction Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class InsertAction extends AddAction
{
    /**
     * @type float $toLocation A sub property of location. The final location of the object or the agent after the action.
     * @Assert\Type(type="float")
     * @ORM\Column(type="float")
     */
    private $toLocation;
}
