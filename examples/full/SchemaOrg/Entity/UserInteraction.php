<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A user interacting with a page
 * 
 * @see http://schema.org/UserInteraction Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class UserInteraction extends Event
{
}
