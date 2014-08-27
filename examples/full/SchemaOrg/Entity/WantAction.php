<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * The act of expressing a desire about the object. An agent wants an object.
 * 
 * @see http://schema.org/WantAction Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class WantAction extends ReactAction
{
}
