<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * The act of granting permission to an object.
 * 
 * @see http://schema.org/AuthorizeAction Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class AuthorizeAction extends AllocateAction
{
    /**
     * @type Audience $recipient A sub property of participant. The participant who is at the receiving end of the action.
     * @ORM\ManyToOne(targetEntity="Audience")
     */
    private $recipient;
}
