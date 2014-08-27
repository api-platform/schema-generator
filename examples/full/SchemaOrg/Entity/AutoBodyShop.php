<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Auto body shop.
 * 
 * @see http://schema.org/AutoBodyShop Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class AutoBodyShop extends AutomotiveBusiness
{
}
