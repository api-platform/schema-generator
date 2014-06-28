<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Drug
 * 
 * @link http://schema.org/Drug
 * 
 * @ORM\Entity
 */
class Drug extends MedicalTherapy
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
     * Administration Route
     * 
     * @var string $administrationRoute A route by which this drug may be administered, e.g. 'oral'.
     * 
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $administrationRoute;
    /**
     * Alcohol Warning
     * 
     * @var string $alcoholWarning Any precaution, guidance, contraindication, etc. related to consumption of alcohol while taking this drug.
     * 
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $alcoholWarning;
    /**
     * Available Strength
     * 
     * @var DrugStrength $availableStrength An available dosage strength for the drug.
     * 
     * @ORM\ManyToOne(targetEntity="DrugStrength")
     */
    private $availableStrength;
    /**
     * Breastfeeding Warning
     * 
     * @var string $breastfeedingWarning Any precaution, guidance, contraindication, etc. related to this drug's use by breastfeeding mothers.
     * 
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $breastfeedingWarning;
    /**
     * Clincal Pharmacology
     * 
     * @var string $clincalPharmacology Description of the absorption and elimination of drugs, including their concentration (pharmacokinetics, pK) and biological effects (pharmacodynamics, pD).
     * 
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $clincalPharmacology;
    /**
     * Cost
     * 
     * @var DrugCost $cost Cost per unit of the drug, as reported by the source being tagged.
     * 
     */
    private $cost;
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
     * Dose Schedule
     * 
     * @var DoseSchedule $doseSchedule A dosing schedule for the drug for a given population, either observed, recommended, or maximum dose based on the type used.
     * 
     * @ORM\ManyToOne(targetEntity="DoseSchedule")
     */
    private $doseSchedule;
    /**
     * Drug Class
     * 
     * @var DrugClass $drugClass The class of drug this belongs to (e.g., statins).
     * 
     * @ORM\ManyToOne(targetEntity="DrugClass")
     * @ORM\JoinColumn(nullable=false)
     */
    private $drugClass;
    /**
     * Food Warning
     * 
     * @var string $foodWarning Any precaution, guidance, contraindication, etc. related to consumption of specific foods while taking this drug.
     * 
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $foodWarning;
    /**
     * Interacting Drug
     * 
     * @var Drug $interactingDrug Another drug that is known to interact with this drug in a way that impacts the effect of this drug or causes a risk to the patient. Note: disease interactions are typically captured as contraindications.
     * 
     */
    private $interactingDrug;
    /**
     * Is Available Generically
     * 
     * @var boolean $isAvailableGenerically True if the drug is available in a generic form (regardless of name).
     * 
     * @Assert\Type(type="boolean")
     * @ORM\Column(type="boolean")
     */
    private $isAvailableGenerically;
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
     * Label Details
     * 
     * @var string $labelDetails Link to the drug's label details.
     * 
     * @Assert\Url
     * @ORM\Column
     */
    private $labelDetails;
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
     * Overdosage
     * 
     * @var string $overdosage Any information related to overdose on a drug, including signs or symptoms, treatments, contact information for emergency response.
     * 
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $overdosage;
    /**
     * Pregnancy Category
     * 
     * @var DrugPregnancyCategory $pregnancyCategory Pregnancy category of this drug.
     * 
     */
    private $pregnancyCategory;
    /**
     * Pregnancy Warning
     * 
     * @var string $pregnancyWarning Any precaution, guidance, contraindication, etc. related to this drug's use during pregnancy.
     * 
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $pregnancyWarning;
    /**
     * Prescribing Info
     * 
     * @var string $prescribingInfo Link to prescribing information for the drug.
     * 
     * @Assert\Url
     * @ORM\Column
     */
    private $prescribingInfo;
    /**
     * Prescription Status
     * 
     * @var DrugPrescriptionStatus $prescriptionStatus Indicates whether this drug is available by prescription or over-the-counter.
     * 
     */
    private $prescriptionStatus;
    /**
     * Related Drug
     * 
     * @var Drug $relatedDrug Any other drug related to this one, for example commonly-prescribed alternatives.
     * 
     */
    private $relatedDrug;
    /**
     * Warning
     * 
     * @var string $warning Any FDA or other warnings about the drug (text or URL).
     * 
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $warning;
}
