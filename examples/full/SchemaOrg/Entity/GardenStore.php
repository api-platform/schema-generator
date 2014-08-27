<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A garden store.
 * 
 * @see http://schema.org/GardenStore Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class GardenStore extends Store
{
}
