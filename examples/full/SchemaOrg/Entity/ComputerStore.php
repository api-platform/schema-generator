<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A computer store.
 * 
 * @see http://schema.org/ComputerStore Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class ComputerStore extends Store
{
}
