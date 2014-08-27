<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A chemical or biologic substance, used as a medical therapy, that has a physiological effect on an organism.
 * 
 * @see http://schema.org/Drug Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class Drug extends MedicalTherapy
{
    /**
     * @type string $activeIngredient An active ingredient, typically chemical compounds and/or biologic substances.
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $activeIngredient;
    /**
     * @type string $administrationRoute A route by which this drug may be administered, e.g. 'oral'.
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $administrationRoute;
    /**
     * @type string $alcoholWarning Any precaution, guidance, contraindication, etc. related to consumption of alcohol while taking this drug.
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $alcoholWarning;
    /**
     * @type DrugStrength $availableStrength An available dosage strength for the drug.
     * @ORM\ManyToOne(targetEntity="DrugStrength")
     */
    private $availableStrength;
    /**
     * @type string $breastfeedingWarning Any precaution, guidance, contraindication, etc. related to this drug's use by breastfeeding mothers.
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $breastfeedingWarning;
    /**
     * @type string $clincalPharmacology Description of the absorption and elimination of drugs, including their concentration (pharmacokinetics, pK) and biological effects (pharmacodynamics, pD).
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $clincalPharmacology;
    /**
     * @type DrugCost $cost Cost per unit of the drug, as reported by the source being tagged.
     */
    private $cost;
    /**
     * @type string $dosageForm A dosage form in which this drug/supplement is available, e.g. 'tablet', 'suspension', 'injection'.
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $dosageForm;
    /**
     * @type DoseSchedule $doseSchedule A dosing schedule for the drug for a given population, either observed, recommended, or maximum dose based on the type used.
     * @ORM\ManyToOne(targetEntity="DoseSchedule")
     */
    private $doseSchedule;
    /**
     * @type DrugClass $drugClass The class of drug this belongs to (e.g., statins).
     * @ORM\ManyToOne(targetEntity="DrugClass")
     * @ORM\JoinColumn(nullable=false)
     */
    private $drugClass;
    /**
     * @type string $foodWarning Any precaution, guidance, contraindication, etc. related to consumption of specific foods while taking this drug.
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $foodWarning;
    /**
     * @type Drug $interactingDrug Another drug that is known to interact with this drug in a way that impacts the effect of this drug or causes a risk to the patient. Note: disease interactions are typically captured as contraindications.
     */
    private $interactingDrug;
    /**
     * @type boolean $isAvailableGenerically True if the drug is available in a generic form (regardless of name).
     * @Assert\Type(type="boolean")
     * @ORM\Column(type="boolean")
     */
    private $isAvailableGenerically;
    /**
     * @type boolean $isProprietary True if this item's name is a proprietary/brand name (vs. generic name).
     * @Assert\Type(type="boolean")
     * @ORM\Column(type="boolean")
     */
    private $isProprietary;
    /**
     * @type string $labelDetails Link to the drug's label details.
     * @Assert\Url
     * @ORM\Column
     */
    private $labelDetails;
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
     * @type string $overdosage Any information related to overdose on a drug, including signs or symptoms, treatments, contact information for emergency response.
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $overdosage;
    /**
     * @type DrugPregnancyCategory $pregnancyCategory Pregnancy category of this drug.
     */
    private $pregnancyCategory;
    /**
     * @type string $pregnancyWarning Any precaution, guidance, contraindication, etc. related to this drug's use during pregnancy.
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $pregnancyWarning;
    /**
     * @type string $prescribingInfo Link to prescribing information for the drug.
     * @Assert\Url
     * @ORM\Column
     */
    private $prescribingInfo;
    /**
     * @type DrugPrescriptionStatus $prescriptionStatus Indicates whether this drug is available by prescription or over-the-counter.
     */
    private $prescriptionStatus;
    /**
     * @type Drug $relatedDrug Any other drug related to this one, for example commonly-prescribed alternatives.
     */
    private $relatedDrug;
    /**
     * @type string $warning Any FDA or other warnings about the drug (text or URL).
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $warning;
}
