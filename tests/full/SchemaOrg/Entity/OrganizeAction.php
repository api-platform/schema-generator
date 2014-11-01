<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * The act of manipulating/administering/supervising/controlling one or more objects.
 * 
 * @see http://schema.org/OrganizeAction Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class OrganizeAction extends Action
{
}
