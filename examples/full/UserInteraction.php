<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * User Interaction
 * 
 * @link http://schema.org/UserInteraction
 * 
 * @ORM\MappedSuperclass
 */
class UserInteraction extends Event
{
}
