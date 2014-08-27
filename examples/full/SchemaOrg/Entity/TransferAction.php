<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * The act of transferring/moving (abstract or concrete) animate or inanimate objects from one place to another.
 * 
 * @see http://schema.org/TransferAction Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class TransferAction extends Action
{
    /**
     * @type float $fromLocation A sub property of location. The original location of the object or the agent before the action.
     * @Assert\Type(type="float")
     * @ORM\Column(type="float")
     */
    private $fromLocation;
    /**
     * @type float $toLocation A sub property of location. The final location of the object or the agent after the action.
     * @Assert\Type(type="float")
     * @ORM\Column(type="float")
     */
    private $toLocation;
}
