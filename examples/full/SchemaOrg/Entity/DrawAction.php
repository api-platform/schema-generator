<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * The act of producing a visual/graphical representation of an object, typically with a pen/pencil and paper as instruments.
 * 
 * @see http://schema.org/DrawAction Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class DrawAction extends CreateAction
{
}
