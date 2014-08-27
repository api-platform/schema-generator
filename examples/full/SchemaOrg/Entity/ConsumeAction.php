<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * The act of ingesting information/resources/food.
 * 
 * @see http://schema.org/ConsumeAction Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class ConsumeAction extends Action
{
}
