<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * An event involving the delivery of an item.
 * 
 * @see http://schema.org/DeliveryEvent Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class DeliveryEvent extends Event
{
    /**
     * @type string $accessCode Password, PIN, or access code needed for delivery (e.g. from a locker).
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $accessCode;
    /**
     * @type \DateTime $availableFrom When the item is available for pickup from the store, locker, etc.
     * @Assert\DateTime
     * @ORM\Column(type="datetime")
     */
    private $availableFrom;
    /**
     * @type \DateTime $availableThrough After this date, the item will no longer be available for pickup.
     * @Assert\DateTime
     * @ORM\Column(type="datetime")
     */
    private $availableThrough;
    /**
     * @type DeliveryMethod $hasDeliveryMethod Method used for delivery or shipping.
     */
    private $hasDeliveryMethod;
}
