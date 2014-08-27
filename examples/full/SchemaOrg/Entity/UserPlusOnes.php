<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * User interaction: +1.
 * 
 * @see http://schema.org/UserPlusOnes Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class UserPlusOnes extends UserInteraction
{
}
