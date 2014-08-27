<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Event type: Visual arts event.
 * 
 * @see http://schema.org/VisualArtsEvent Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class VisualArtsEvent extends Event
{
}
