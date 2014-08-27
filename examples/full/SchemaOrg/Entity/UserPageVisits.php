<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * User interaction: Visit to a web page.
 * 
 * @see http://schema.org/UserPageVisits Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class UserPageVisits extends UserInteraction
{
}
