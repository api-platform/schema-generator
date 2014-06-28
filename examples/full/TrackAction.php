<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Track Action
 * 
 * @link http://schema.org/TrackAction
 * 
 * @ORM\Entity
 */
class TrackAction extends FindAction
{
    /**
     * Delivery Method
     * 
     * @var DeliveryMethod $deliveryMethod A sub property of instrument. The method of delivery
     * 
     * @ORM\ManyToOne(targetEntity="DeliveryMethod")
     */
    private $deliveryMethod;
}
