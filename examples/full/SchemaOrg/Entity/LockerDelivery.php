<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A DeliveryMethod in which an item is made available via locker.
 * 
 * @see http://schema.org/LockerDelivery Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class LockerDelivery extends DeliveryMethod
{
}
