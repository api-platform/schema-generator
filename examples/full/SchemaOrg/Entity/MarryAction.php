<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * The act of marrying a person.
 * 
 * @see http://schema.org/MarryAction Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class MarryAction extends InteractAction
{
}
