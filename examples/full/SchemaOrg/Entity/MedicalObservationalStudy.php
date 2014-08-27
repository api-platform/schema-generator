<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * An observational study is a type of medical study that attempts to infer the possible effect of a treatment through observation of a cohort of subjects over a period of time. In an observational study, the assignment of subjects into treatment groups versus control groups is outside the control of the investigator. This is in contrast with controlled studies, such as the randomized controlled trials represented by MedicalTrial, where each subject is randomly assigned to a treatment group or a control group before the start of the treatment.
 * 
 * @see http://schema.org/MedicalObservationalStudy Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class MedicalObservationalStudy extends MedicalStudy
{
    /**
     * @type MedicalObservationalStudyDesign $studyDesign Specifics about the observational study design (enumerated).
     */
    private $studyDesign;
}
