<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A country.
 * 
 * @see http://schema.org/Country Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class Country extends AdministrativeArea
{
}
