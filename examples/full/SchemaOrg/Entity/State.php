<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A state or province of a country.
 * 
 * @see http://schema.org/State Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class State extends AdministrativeArea
{
}
