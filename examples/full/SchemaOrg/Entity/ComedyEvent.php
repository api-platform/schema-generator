<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Event type: Comedy event.
 * 
 * @see http://schema.org/ComedyEvent Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class ComedyEvent extends Event
{
}
