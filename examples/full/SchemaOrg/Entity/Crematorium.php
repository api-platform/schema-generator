<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A crematorium.
 * 
 * @see http://schema.org/Crematorium Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class Crematorium extends CivicStructure
{
}
