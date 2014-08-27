<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * The act of an agent relocating to a place.<p>Related actions:</p><ul><li><a href="http://schema.org/TransferAction">TransferAction</a>: Unlike TransferAction, the subject of the move is a living Person or Organization rather than an inanimate object.</li></ul>
 * 
 * @see http://schema.org/MoveAction Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class MoveAction extends Action
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
