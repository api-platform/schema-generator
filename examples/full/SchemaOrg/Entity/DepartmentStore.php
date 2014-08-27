<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A department store.
 * 
 * @see http://schema.org/DepartmentStore Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class DepartmentStore extends Store
{
}
