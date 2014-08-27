<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Event type: Festival.
 * 
 * @see http://schema.org/Festival Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class Festival extends Event
{
}
