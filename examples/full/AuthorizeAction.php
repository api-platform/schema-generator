<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Authorize Action
 * 
 * @link http://schema.org/AuthorizeAction
 * 
 * @ORM\Entity
 */
class AuthorizeAction extends AllocateAction
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
