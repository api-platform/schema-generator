<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Payment Method
 * 
 * @link http://schema.org/PaymentMethod
 * 
 * @ORM\MappedSuperclass
 */
class PaymentMethod extends Enumeration
{
}
