<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A mountain, like Mount Whitney or Mount Everest
 * 
 * @see http://schema.org/Mountain Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class Mountain extends Landform
{
}
