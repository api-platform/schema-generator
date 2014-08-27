<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A doctor's office.
 * 
 * @see http://schema.org/Physician Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class Physician extends MedicalOrganization
{
    /**
     * @type MedicalProcedure $availableService A medical service available from this provider.
     * @ORM\ManyToOne(targetEntity="MedicalProcedure")
     */
    private $availableService;
    /**
     * @type Hospital $hospitalAffiliation A hospital with which the physician or office is affiliated.
     * @ORM\ManyToOne(targetEntity="Hospital")
     */
    private $hospitalAffiliation;
    /**
     * @type MedicalSpecialty $medicalSpecialty A medical specialty of the provider.
     * @ORM\ManyToOne(targetEntity="MedicalSpecialty")
     */
    private $medicalSpecialty;
}
