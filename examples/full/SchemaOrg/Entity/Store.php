<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A retail good store.
 * 
 * @see http://schema.org/Store Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class Store extends LocalBusiness
{
}
