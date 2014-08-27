<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * User interaction: Block this content.
 * 
 * @see http://schema.org/UserBlocks Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class UserBlocks extends UserInteraction
{
}
