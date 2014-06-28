<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Medical Code
 * 
 * @link http://schema.org/MedicalCode
 * 
 * @ORM\Entity
 */
class MedicalCode extends MedicalIntangible
{
    /**
     * Code Value
     * 
     * @var string $codeValue The actual code.
     * 
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $codeValue;
    /**
     * Coding System
     * 
     * @var string $codingSystem The coding system, e.g. 'ICD-10'.
     * 
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $codingSystem;
}
