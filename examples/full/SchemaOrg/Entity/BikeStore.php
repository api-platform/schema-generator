<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A bike store.
 * 
 * @see http://schema.org/BikeStore Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class BikeStore extends Store
{
}
