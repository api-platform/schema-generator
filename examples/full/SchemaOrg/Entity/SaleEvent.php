<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Event type: Sales event.
 * 
 * @see http://schema.org/SaleEvent Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class SaleEvent extends Event
{
}
