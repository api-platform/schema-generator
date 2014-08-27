<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Event type: Food event.
 * 
 * @see http://schema.org/FoodEvent Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class FoodEvent extends Event
{
}
