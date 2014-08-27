<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * The act of discovering/finding an object.
 * 
 * @see http://schema.org/DiscoverAction Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class DiscoverAction extends FindAction
{
}
