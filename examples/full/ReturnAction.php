<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Return Action
 * 
 * @link http://schema.org/ReturnAction
 * 
 * @ORM\Entity
 */
class ReturnAction extends TransferAction
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
