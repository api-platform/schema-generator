<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * The act of swallowing solid objects.
 * 
 * @see http://schema.org/EatAction Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class EatAction extends ConsumeAction
{
}
