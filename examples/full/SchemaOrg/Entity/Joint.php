<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * The anatomical location at which two or more bones make contact.
 * 
 * @see http://schema.org/Joint Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class Joint extends AnatomicalStructure
{
    /**
     * @type string $biomechnicalClass The biomechanical properties of the bone.
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $biomechnicalClass;
    /**
     * @type string $functionalClass The degree of mobility the joint allows.
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $functionalClass;
    /**
     * @type string $structuralClass The name given to how bone physically connects to each other.
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $structuralClass;
}
