<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * The act of being defeated in a competitive activity.
 * 
 * @see http://schema.org/LoseAction Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class LoseAction extends AchieveAction
{
    /**
     * @type Person $winner A sub property of participant. The winner of the action.
     * @ORM\ManyToOne(targetEntity="Person")
     */
    private $winner;
}
