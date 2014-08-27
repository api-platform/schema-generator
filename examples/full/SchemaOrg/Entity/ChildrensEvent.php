<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Event type: Children's event.
 * 
 * @see http://schema.org/ChildrensEvent Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class ChildrensEvent extends Event
{
}
