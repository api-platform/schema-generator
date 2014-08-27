<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * The act of transferring ownership of an object to a destination. Reciprocal of TakeAction.<p>Related actions:</p><ul><li><a href="http://schema.org/TakeAction">TakeAction</a>: Reciprocal of GiveAction.</li><li><a href="http://schema.org/SendAction">SendAction</a>: Unlike SendAction, GiveAction implies that ownership is being transferred (e.g. I may send my laptop to you, but that doesn't mean I'm giving it to you).</li></ul>
 * 
 * @see http://schema.org/GiveAction Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class GiveAction extends TransferAction
{
    /**
     * @type Audience $recipient A sub property of participant. The participant who is at the receiving end of the action.
     * @ORM\ManyToOne(targetEntity="Audience")
     */
    private $recipient;
}
