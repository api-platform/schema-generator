<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Place of Worship
 * 
 * @link http://schema.org/PlaceOfWorship
 * 
 * @ORM\MappedSuperclass
 */
class PlaceOfWorship extends CivicStructure
{
}
