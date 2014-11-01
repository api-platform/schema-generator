<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Rigid connective tissue that comprises up the skeletal structure of the human body.
 * 
 * @see http://schema.org/Bone Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class Bone extends AnatomicalStructure
{
}
