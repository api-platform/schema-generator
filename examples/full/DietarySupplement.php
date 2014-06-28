<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Dietary Supplement
 * 
 * @link http://schema.org/DietarySupplement
 * 
 * @ORM\Entity
 */
class DietarySupplement extends MedicalTherapy
{
    /**
     * Active Ingredient
     * 
     * @var string $activeIngredient An active ingredient, typically chemical compounds and/or biologic substances.
     * 
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $activeIngredient;
    /**
     * Background
     * 
     * @var string $background Descriptive information establishing a historical perspective on the supplement. May include the rationale for the name, the population where the supplement first came to prominence, etc.
     * 
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $background;
    /**
     * Dosage Form
     * 
     * @var string $dosageForm A dosage form in which this drug/supplement is available, e.g. 'tablet', 'suspension', 'injection'.
     * 
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $dosageForm;
    /**
     * Is Proprietary
     * 
     * @var boolean $isProprietary True if this item's name is a proprietary/brand name (vs. generic name).
     * 
     * @Assert\Type(type="boolean")
     * @ORM\Column(type="boolean")
     */
    private $isProprietary;
    /**
     * Legal Status
     * 
     * @var DrugLegalStatus $legalStatus The drug or supplement's legal status, including any controlled substance schedules that apply.
     * 
     * @ORM\ManyToOne(targetEntity="DrugLegalStatus")
     * @ORM\JoinColumn(nullable=false)
     */
    private $legalStatus;
    /**
     * Manufacturer
     * 
     * @var Organization $manufacturer The manufacturer of the product.
     * 
     * @ORM\OneToOne(targetEntity="Organization")
     */
    private $manufacturer;
    /**
     * Maximum Intake
     * 
     * @var MaximumDoseSchedule $maximumIntake Recommended intake of this supplement for a given population as defined by a specific recommending authority.
     * 
     */
    private $maximumIntake;
    /**
     * Mechanism of Action
     * 
     * @var string $mechanismOfAction The specific biochemical interaction through which this drug or supplement produces its pharmacological effect.
     * 
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $mechanismOfAction;
    /**
     * Non Proprietary Name
     * 
     * @var string $nonProprietaryName The generic name of this drug or supplement.
     * 
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $nonProprietaryName;
    /**
     * Recommended Intake
     * 
     * @var RecommendedDoseSchedule $recommendedIntake Recommended intake of this supplement for a given population as defined by a specific recommending authority.
     * 
     */
    private $recommendedIntake;
    /**
     * Safety Consideration
     * 
     * @var string $safetyConsideration Any potential safety concern associated with the supplement. May include interactions with other drugs and foods, pregnancy, breastfeeding, known adverse reactions, and documented efficacy of the supplement.
     * 
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $safetyConsideration;
    /**
     * Target Population
     * 
     * @var string $targetPopulation Characteristics of the population for which this is intended, or which typically uses it, e.g. 'adults'.
     * 
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $targetPopulation;
}
