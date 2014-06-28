<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Medical Observational Study
 * 
 * @link http://schema.org/MedicalObservationalStudy
 * 
 * @ORM\Entity
 */
class MedicalObservationalStudy extends MedicalStudy
{
    /**
     * Study Design
     * 
     * @var MedicalObservationalStudyDesign $studyDesign Specifics about the observational study design (enumerated).
     * 
     */
    private $studyDesign;
}
