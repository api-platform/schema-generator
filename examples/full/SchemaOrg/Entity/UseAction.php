<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * The act of applying an object to its intended purpose.
 * 
 * @see http://schema.org/UseAction Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class UseAction extends ConsumeAction
{
}
