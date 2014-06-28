<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Send Action
 * 
 * @link http://schema.org/SendAction
 * 
 * @ORM\Entity
 */
class SendAction extends TransferAction
{
    /**
     * Delivery Method
     * 
     * @var DeliveryMethod $deliveryMethod A sub property of instrument. The method of delivery
     * 
     * @ORM\ManyToOne(targetEntity="DeliveryMethod")
     */
    private $deliveryMethod;
    /**
     * Recipient
     * 
     * @var Organization $recipient A sub property of participant. The participant who is at the receiving end of the action.
     * 
     * @ORM\ManyToOne(targetEntity="Organization")
     */
    private $recipient;
}
