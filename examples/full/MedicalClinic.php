<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Medical Clinic
 * 
 * @link http://schema.org/MedicalClinic
 * 
 * @ORM\Entity
 */
class MedicalClinic extends MedicalOrganization
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
     * Medical Specialty
     * 
     * @var MedicalSpecialty $medicalSpecialty A medical specialty of the provider.
     * 
     * @ORM\ManyToOne(targetEntity="MedicalSpecialty")
     */
    private $medicalSpecialty;
}
