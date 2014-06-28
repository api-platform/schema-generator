<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Broadcast Event
 * 
 * @link http://schema.org/BroadcastEvent
 * 
 * @ORM\Entity
 */
class BroadcastEvent extends PublicationEvent
{
}
