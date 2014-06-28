<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Physician
 * 
 * @link http://schema.org/Physician
 * 
 * @ORM\Entity
 */
class Physician extends MedicalOrganization
{
    /**
     * Available Service
     * 
     * @var MedicalTest $availableService A medical service available from this provider.
     * 
     * @ORM\ManyToOne(targetEntity="MedicalTest")
     */
    private $availableService;
    /**
     * Hospital Affiliation
     * 
     * @var Hospital $hospitalAffiliation A hospital with which the physician or office is affiliated.
     * 
     * @ORM\ManyToOne(targetEntity="Hospital")
     */
    private $hospitalAffiliation;
    /**
     * Medical Specialty
     * 
     * @var MedicalSpecialty $medicalSpecialty A medical specialty of the provider.
     * 
     * @ORM\ManyToOne(targetEntity="MedicalSpecialty")
     */
    private $medicalSpecialty;
}
