<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A taxi.
 * 
 * @see http://schema.org/Taxi Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class Taxi extends Service
{
}
