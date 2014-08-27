<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A bar or pub.
 * 
 * @see http://schema.org/BarOrPub Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class BarOrPub extends FoodEstablishment
{
}
