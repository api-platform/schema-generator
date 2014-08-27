<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Event type: Education event.
 * 
 * @see http://schema.org/EducationEvent Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class EducationEvent extends Event
{
}
