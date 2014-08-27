<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A volcano, like Fuji san.
 * 
 * @see http://schema.org/Volcano Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class Volcano extends Landform
{
}
