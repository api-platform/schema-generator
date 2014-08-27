<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * An auto parts store.
 * 
 * @see http://schema.org/AutoPartsStore Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class AutoPartsStore extends AutomotiveBusiness
{
}
