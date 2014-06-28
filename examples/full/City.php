<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * City
 * 
 * @link http://schema.org/City
 * 
 * @ORM\Entity
 */
class City extends AdministrativeArea
{
}
