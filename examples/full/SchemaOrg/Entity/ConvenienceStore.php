<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A convenience store.
 * 
 * @see http://schema.org/ConvenienceStore Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class ConvenienceStore extends Store
{
}
