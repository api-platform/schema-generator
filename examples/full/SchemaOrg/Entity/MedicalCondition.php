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
     * @type AnatomicalStructure $associatedAnatomy The anatomy of the underlying organ system or structures associated with this entity.
     * @ORM\ManyToOne(targetEntity="AnatomicalStructure")
     * @ORM\JoinColumn(nullable=false)
     */
    private $associatedAnatomy;
    /**
     * @type MedicalCause $cause An underlying cause. More specifically, one of the causative agent(s) that are most directly responsible for the pathophysiologic process that eventually results in the occurrence.
     * @ORM\ManyToOne(targetEntity="MedicalCause")
     */
    private $cause;
    /**
     * @type DDxElement $differentialDiagnosis One of a set of differential diagnoses for the condition. Specifically, a closely-related or competing diagnosis typically considered later in the cognitive process whereby this medical condition is distinguished from others most likely responsible for a similar collection of signs and symptoms to reach the most parsimonious diagnosis or diagnoses in a patient.
     */
    private $differentialDiagnosis;
    /**
     * @type string $epidemiology The characteristics of associated patients, such as age, gender, race etc.
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $epidemiology;
    /**
     * @type string $expectedPrognosis The likely outcome in either the short term or long term of the medical condition.
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $expectedPrognosis;
    /**
     * @type string $naturalProgression The expected progression of the condition if it is not treated and allowed to progress naturally.
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $naturalProgression;
    /**
     * @type string $pathophysiology Changes in the normal mechanical, physical, and biochemical functions that are associated with this activity or condition.
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $pathophysiology;
    /**
     * @type string $possibleComplication A possible unexpected and unfavorable evolution of a medical condition. Complications may include worsening of the signs or symptoms of the disease, extension of the condition to other organ systems, etc.
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $possibleComplication;
    /**
     * @type MedicalTherapy $possibleTreatment A possible treatment to address this condition, sign or symptom.
     * @ORM\ManyToOne(targetEntity="MedicalTherapy")
     */
    private $possibleTreatment;
    /**
     * @type MedicalTherapy $primaryPrevention A preventative therapy used to prevent an initial occurrence of the medical condition, such as vaccination.
     * @ORM\ManyToOne(targetEntity="MedicalTherapy")
     */
    private $primaryPrevention;
    /**
     * @type MedicalRiskFactor $riskFactor A modifiable or non-modifiable factor that increases the risk of a patient contracting this condition, e.g. age,  coexisting condition.
     * @ORM\ManyToOne(targetEntity="MedicalRiskFactor")
     */
    private $riskFactor;
    /**
     * @type MedicalTherapy $secondaryPrevention A preventative therapy used to prevent reoccurrence of the medical condition after an initial episode of the condition.
     * @ORM\ManyToOne(targetEntity="MedicalTherapy")
     */
    private $secondaryPrevention;
    /**
     * @type MedicalSignOrSymptom $signOrSymptom A sign or symptom of this condition. Signs are objective or physically observable manifestations of the medical condition while symptoms are the subjective experience of the medical condition.
     * @ORM\ManyToOne(targetEntity="MedicalSignOrSymptom")
     */
    private $signOrSymptom;
    /**
     * @type MedicalConditionStage $stage The stage of the condition, if applicable.
     * @ORM\ManyToOne(targetEntity="MedicalConditionStage")
     * @ORM\JoinColumn(nullable=false)
     */
    private $stage;
    /**
     * @type string $subtype A more specific type of the condition, where applicable, for example 'Type 1 Diabetes', 'Type 2 Diabetes', or 'Gestational Diabetes' for Diabetes.
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $subtype;
    /**
     * @type MedicalTest $typicalTest A medical test typically performed given this condition.
     * @ORM\ManyToOne(targetEntity="MedicalTest")
     */
    private $typicalTest;
}
