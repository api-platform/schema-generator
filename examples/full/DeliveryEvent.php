<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Delivery Event
 * 
 * @link http://schema.org/DeliveryEvent
 * 
 * @ORM\Entity
 */
class DeliveryEvent extends Event
{
    /**
     * Access Code
     * 
     * @var string $accessCode Password, PIN, or access code needed for delivery (e.g. from a locker).
     * 
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $accessCode;
    /**
     * Available From
     * 
     * @var \DateTime $availableFrom When the item is available for pickup from the store, locker, etc.
     * 
     * @Assert\DateTime
     * @ORM\Column(type="datetime")
     */
    private $availableFrom;
    /**
     * Available Through
     * 
     * @var \DateTime $availableThrough After this date, the item will no longer be available for pickup.
     * 
     * @Assert\DateTime
     * @ORM\Column(type="datetime")
     */
    private $availableThrough;
    /**
     * Has Delivery Method
     * 
     * @var DeliveryMethod $hasDeliveryMethod Method used for delivery or shipping.
     * 
     */
    private $hasDeliveryMethod;
}
