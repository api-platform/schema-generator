<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * The act of intentionally disregarding the object. An agent ignores an object.
 * 
 * @see http://schema.org/IgnoreAction Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class IgnoreAction extends AssessAction
{
}
