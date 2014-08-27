<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A florist.
 * 
 * @see http://schema.org/Florist Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class Florist extends Store
{
}
