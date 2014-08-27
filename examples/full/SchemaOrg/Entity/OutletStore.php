<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * An outlet store.
 * 
 * @see http://schema.org/OutletStore Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class OutletStore extends Store
{
}
