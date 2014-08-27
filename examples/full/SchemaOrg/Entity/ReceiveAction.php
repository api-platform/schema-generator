<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * The act of physically/electronically taking delivery of an object thathas been transferred from an origin to a destination. Reciprocal of SendAction.<p>Related actions:</p><ul><li><a href="http://schema.org/SendAction">SendAction</a>: The reciprocal of ReceiveAction.</li><li><a href="http://schema.org/TakeAction">TakeAction</a>: Unlike TakeAction, ReceiveAction does not imply that the ownership has been transfered (e.g. I can receive a package, but it does not mean the package is now mine).</li></ul>
 * 
 * @see http://schema.org/ReceiveAction Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class ReceiveAction extends TransferAction
{
    /**
     * @type DeliveryMethod $deliveryMethod A sub property of instrument. The method of delivery
     * @ORM\ManyToOne(targetEntity="DeliveryMethod")
     */
    private $deliveryMethod;
    /**
     * @type Audience $sender A sub property of participant. The participant who is at the sending end of the action.
     * @ORM\ManyToOne(targetEntity="Audience")
     */
    private $sender;
}
