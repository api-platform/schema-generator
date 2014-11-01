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
     */
    private $codeValue;
    /**
     */
    private $codingSystem;
}
