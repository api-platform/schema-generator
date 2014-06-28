<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Tip Action
 * 
 * @link http://schema.org/TipAction
 * 
 * @ORM\Entity
 */
class TipAction extends TradeAction
{
    /**
     * Recipient
     * 
     * @var Organization $recipient A sub property of participant. The participant who is at the receiving end of the action.
     * 
     * @ORM\ManyToOne(targetEntity="Organization")
     */
    private $recipient;
}
