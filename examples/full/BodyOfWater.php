<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Body of Water
 * 
 * @link http://schema.org/BodyOfWater
 * 
 * @ORM\MappedSuperclass
 */
class BodyOfWater extends Landform
{
}
