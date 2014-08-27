<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Lists or enumerations&#x2014;for example, a list of cuisines or music genres, etc.
 * 
 * @see http://schema.org/Enumeration Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class Enumeration extends Intangible
{
}
