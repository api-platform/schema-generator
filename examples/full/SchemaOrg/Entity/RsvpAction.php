<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * The act of notifying an event organizer as to whether you expect to attend the event.
 * 
 * @see http://schema.org/RsvpAction Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class RsvpAction extends InformAction
{
}
