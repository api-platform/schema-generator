<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Place of worship, such as a church, synagogue, or mosque.
 * 
 * @see http://schema.org/PlaceOfWorship Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class PlaceOfWorship extends CivicStructure
{
}
