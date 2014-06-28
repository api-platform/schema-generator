<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Pay Action
 * 
 * @link http://schema.org/PayAction
 * 
 * @ORM\Entity
 */
class PayAction extends TradeAction
{
    /**
     * Purpose
     * 
     * @var Thing $purpose A goal towards an action is taken. Can be concrete or abstract.
     * 
     * @ORM\ManyToOne(targetEntity="Thing")
     */
    private $purpose;
    /**
     * Recipient
     * 
     * @var Organization $recipient A sub property of participant. The participant who is at the receiving end of the action.
     * 
     * @ORM\ManyToOne(targetEntity="Organization")
     */
    private $recipient;
}
