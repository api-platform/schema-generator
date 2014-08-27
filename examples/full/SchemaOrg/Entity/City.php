<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A city or town.
 * 
 * @see http://schema.org/City Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class City extends AdministrativeArea
{
}
