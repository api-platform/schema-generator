<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A short band of tough, flexible, fibrous connective tissue that functions to connect multiple bones, cartilages, and structurally support joints.
 * 
 * @see http://schema.org/Ligament Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class Ligament extends AnatomicalStructure
{
}
