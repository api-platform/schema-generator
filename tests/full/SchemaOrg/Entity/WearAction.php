<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * The act of dressing oneself in clothing.
 * 
 * @see http://schema.org/WearAction Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class WearAction extends UseAction
{
}
