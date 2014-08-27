<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A hospital.
 * 
 * @see http://schema.org/Hospital Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class Hospital extends CivicStructure
{
    /**
     * @type MedicalProcedure $availableService A medical service available from this provider.
     * @ORM\ManyToOne(targetEntity="MedicalProcedure")
     */
    private $availableService;
    /**
     * @type MedicalSpecialty $medicalSpecialty A medical specialty of the provider.
     * @ORM\ManyToOne(targetEntity="MedicalSpecialty")
     */
    private $medicalSpecialty;
}
