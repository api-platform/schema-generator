<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * An over the air or online broadcast event.
 * 
 * @see http://schema.org/BroadcastEvent Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class BroadcastEvent extends PublicationEvent
{
}
