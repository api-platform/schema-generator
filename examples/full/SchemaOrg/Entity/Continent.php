<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * One of the continents (for example, Europe or Africa).
 * 
 * @see http://schema.org/Continent Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class Continent extends Landform
{
}
