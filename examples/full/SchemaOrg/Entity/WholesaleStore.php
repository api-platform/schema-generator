<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A wholesale store.
 * 
 * @see http://schema.org/WholesaleStore Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class WholesaleStore extends Store
{
}
