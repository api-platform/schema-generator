<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * An electronics store.
 * 
 * @see http://schema.org/ElectronicsStore Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class ElectronicsStore extends Store
{
}
