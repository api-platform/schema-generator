<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * The act of swallowing liquids.
 * 
 * @see http://schema.org/DrinkAction Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class DrinkAction extends ConsumeAction
{
}
