<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Landform
 * 
 * @link http://schema.org/Landform
 * 
 * @ORM\MappedSuperclass
 */
class Landform extends Place
{
}
