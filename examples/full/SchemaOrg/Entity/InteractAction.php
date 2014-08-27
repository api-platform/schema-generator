<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * The act of interacting with another person or organization.
 * 
 * @see http://schema.org/InteractAction Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class InteractAction extends Action
{
}
