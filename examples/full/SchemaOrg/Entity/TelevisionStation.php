<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A television station.
 * 
 * @see http://schema.org/TelevisionStation Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class TelevisionStation extends LocalBusiness
{
}
