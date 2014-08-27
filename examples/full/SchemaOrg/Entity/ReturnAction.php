<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * The act of returning to the origin that which was previously received (concrete objects) or taken (ownership).
 * 
 * @see http://schema.org/ReturnAction Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class ReturnAction extends TransferAction
{
    /**
     * @type Audience $recipient A sub property of participant. The participant who is at the receiving end of the action.
     * @ORM\ManyToOne(targetEntity="Audience")
     */
    private $recipient;
}
