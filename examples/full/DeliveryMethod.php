<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Delivery Method
 * 
 * @link http://schema.org/DeliveryMethod
 * 
 * @ORM\MappedSuperclass
 */
class DeliveryMethod extends Enumeration
{
}
