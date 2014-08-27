<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Event type: Literary event.
 * 
 * @see http://schema.org/LiteraryEvent Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class LiteraryEvent extends Event
{
}
