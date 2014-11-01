<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * The act of producing a painting, typically with paint and canvas as instruments.
 * 
 * @see http://schema.org/PaintAction Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class PaintAction extends CreateAction
{
}
