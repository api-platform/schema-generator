<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * The most generic type of entity related to health and the practice of medicine.
 * 
 * @see http://schema.org/MedicalEntity Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class MedicalEntity extends Thing
{
    /**
     */
    private $alternateName;
    /**
     */
    private $code;
    /**
     */
    private $guideline;
    /**
     */
    private $medicineSystem;
    /**
     */
    private $recognizingAuthority;
    /**
     */
    private $relevantSpecialty;
    /**
     */
    private $study;
}
