<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * User interaction: Download of an item.
 * 
 * @see http://schema.org/UserDownloads Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class UserDownloads extends UserInteraction
{
}
