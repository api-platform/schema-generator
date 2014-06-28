<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Order Status
 * 
 * @link http://schema.org/OrderStatus
 * 
 * @ORM\Entity
 */
class OrderStatus extends Enumeration
{
}
