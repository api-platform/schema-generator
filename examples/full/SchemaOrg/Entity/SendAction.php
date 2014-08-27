<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * The act of physically/electronically dispatching an object for transfer from an origin to a destination.<p>Related actions:</p><ul><li><a href="http://schema.org/ReceiveAction">ReceiveAction</a>: The reciprocal of SendAction.</li><li><a href="http://schema.org/GiveAction">GiveAction</a>: Unlike GiveAction, SendAction does not imply the transfer of ownership (e.g. I can send you my laptop, but I'm not necessarily giving it to you).</li></ul>
 * 
 * @see http://schema.org/SendAction Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class SendAction extends TransferAction
{
    /**
     * @type DeliveryMethod $deliveryMethod A sub property of instrument. The method of delivery
     * @ORM\ManyToOne(targetEntity="DeliveryMethod")
     */
    private $deliveryMethod;
    /**
     * @type Audience $recipient A sub property of participant. The participant who is at the receiving end of the action.
     * @ORM\ManyToOne(targetEntity="Audience")
     */
    private $recipient;
}
