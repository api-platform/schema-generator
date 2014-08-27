<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A code for a medical entity.
 * 
 * @see http://schema.org/MedicalCode Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class MedicalCode extends MedicalIntangible
{
    /**
     * @type string $codeValue The actual code.
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $codeValue;
    /**
     * @type string $codingSystem The coding system, e.g. 'ICD-10'.
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $codingSystem;
}
