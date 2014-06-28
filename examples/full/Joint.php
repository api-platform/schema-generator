<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Joint
 * 
 * @link http://schema.org/Joint
 * 
 * @ORM\Entity
 */
class Joint extends AnatomicalStructure
{
    /**
     * Biomechnical Class
     * 
     * @var string $biomechnicalClass The biomechanical properties of the bone.
     * 
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $biomechnicalClass;
    /**
     * Functional Class
     * 
     * @var string $functionalClass The degree of mobility the joint allows.
     * 
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $functionalClass;
    /**
     * Structural Class
     * 
     * @var string $structuralClass The name given to how bone physically connects to each other.
     * 
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $structuralClass;
}
