<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Credit Card
 * 
 * @link http://schema.org/CreditCard
 * 
 * @ORM\Entity
 */
class CreditCard extends PaymentMethod
{
}
