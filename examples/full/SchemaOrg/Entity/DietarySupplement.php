<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A product taken by mouth that contains a dietary ingredient intended to supplement the diet. Dietary ingredients may include vitamins, minerals, herbs or other botanicals, amino acids, and substances such as enzymes, organ tissues, glandulars and metabolites.
 * 
 * @see http://schema.org/DietarySupplement Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class DietarySupplement extends MedicalTherapy
{
    /**
     * @type string $activeIngredient An active ingredient, typically chemical compounds and/or biologic substances.
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $activeIngredient;
    /**
     * @type string $background Descriptive information establishing a historical perspective on the supplement. May include the rationale for the name, the population where the supplement first came to prominence, etc.
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $background;
    /**
     * @type string $dosageForm A dosage form in which this drug/supplement is available, e.g. 'tablet', 'suspension', 'injection'.
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $dosageForm;
    /**
     * @type boolean $isProprietary True if this item's name is a proprietary/brand name (vs. generic name).
     * @Assert\Type(type="boolean")
     * @ORM\Column(type="boolean")
     */
    private $isProprietary;
    /**
     * @type DrugLegalStatus $legalStatus The drug or supplement's legal status, including any controlled substance schedules that apply.
     * @ORM\ManyToOne(targetEntity="DrugLegalStatus")
     * @ORM\JoinColumn(nullable=false)
     */
    private $legalStatus;
    /**
     * @type Organization $manufacturer The manufacturer of the product.
     * @ORM\OneToOne(targetEntity="Organization")
     */
    private $manufacturer;
    /**
     * @type MaximumDoseSchedule $maximumIntake Recommended intake of this supplement for a given population as defined by a specific recommending authority.
     */
    private $maximumIntake;
    /**
     * @type string $mechanismOfAction The specific biochemical interaction through which this drug or supplement produces its pharmacological effect.
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $mechanismOfAction;
    /**
     * @type string $nonProprietaryName The generic name of this drug or supplement.
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $nonProprietaryName;
    /**
     * @type RecommendedDoseSchedule $recommendedIntake Recommended intake of this supplement for a given population as defined by a specific recommending authority.
     */
    private $recommendedIntake;
    /**
     * @type string $safetyConsideration Any potential safety concern associated with the supplement. May include interactions with other drugs and foods, pregnancy, breastfeeding, known adverse reactions, and documented efficacy of the supplement.
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $safetyConsideration;
    /**
     * @type string $targetPopulation Characteristics of the population for which this is intended, or which typically uses it, e.g. 'adults'.
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $targetPopulation;
}
