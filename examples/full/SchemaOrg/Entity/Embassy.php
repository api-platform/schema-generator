<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * An embassy.
 * 
 * @see http://schema.org/Embassy Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class Embassy extends GovernmentBuilding
{
}
