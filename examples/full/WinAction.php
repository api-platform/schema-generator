<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Win Action
 * 
 * @link http://schema.org/WinAction
 * 
 * @ORM\Entity
 */
class WinAction extends AchieveAction
{
    /**
     * Loser
     * 
     * @var Person $loser A sub property of participant. The loser of the action.
     * 
     * @ORM\ManyToOne(targetEntity="Person")
     */
    private $loser;
}
