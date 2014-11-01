<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Any condition of the human body that affects the normal functioning of a person, whether physically or mentally. Includes diseases, injuries, disabilities, disorders, syndromes, etc.
 * 
 * @see http://schema.org/MedicalCondition Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class MedicalCondition extends MedicalEntity
{
    /**
     */
    private $associatedAnatomy;
    /**
     */
    private $cause;
    /**
     */
    private $differentialDiagnosis;
    /**
     */
    private $epidemiology;
    /**
     */
    private $expectedPrognosis;
    /**
     */
    private $naturalProgression;
    /**
     */
    private $pathophysiology;
    /**
     */
    private $possibleComplication;
    /**
     */
    private $possibleTreatment;
    /**
     */
    private $primaryPrevention;
    /**
     */
    private $riskFactor;
    /**
     */
    private $secondaryPrevention;
    /**
     */
    private $signOrSymptom;
    /**
     */
    private $stage;
    /**
     */
    private $subtype;
    /**
     */
    private $typicalTest;
}
