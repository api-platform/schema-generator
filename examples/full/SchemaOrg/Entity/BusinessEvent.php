<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Event type: Business event.
 * 
 * @see http://schema.org/BusinessEvent Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class BusinessEvent extends Event
{
}
