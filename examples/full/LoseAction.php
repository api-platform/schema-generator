<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Lose Action
 * 
 * @link http://schema.org/LoseAction
 * 
 * @ORM\Entity
 */
class LoseAction extends AchieveAction
{
    /**
     * Winner
     * 
     * @var Person $winner A sub property of participant. The winner of the action.
     * 
     * @ORM\ManyToOne(targetEntity="Person")
     */
    private $winner;
}
