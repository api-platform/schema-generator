<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Residence type: Single-family home.
 * 
 * @see http://schema.org/SingleFamilyResidence Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class SingleFamilyResidence extends Residence
{
}
