<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Receive Action
 * 
 * @link http://schema.org/ReceiveAction
 * 
 * @ORM\Entity
 */
class ReceiveAction extends TransferAction
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
     * Sender
     * 
     * @var Audience $sender A sub property of participant. The participant who is at the sending end of the action.
     * 
     * @ORM\ManyToOne(targetEntity="Audience")
     */
    private $sender;
}
