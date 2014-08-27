<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A tourist attraction.
 * 
 * @see http://schema.org/TouristAttraction Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class TouristAttraction extends Place
{
}
