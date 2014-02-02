<?php

namespace SchemaOrg;

/**
 * Drug
 *
 * @link http://schema.org/Drug
 */
class Drug extends MedicalTherapy
{
    /**
     * Active Ingredient
     *
     * @var string An active ingredient, typically chemical compounds and/or biologic substances.
     */
    protected $activeIngredient;
    /**
     * Administration Route
     *
     * @var string A route by which this drug may be administered, e.g. 'oral'.
     */
    protected $administrationRoute;
    /**
     * Alcohol Warning
     *
     * @var string Any precaution, guidance, contraindication, etc. related to consumption of alcohol while taking this drug.
     */
    protected $alcoholWarning;
    /**
     * Available Strength
     *
     * @var DrugStrength An available dosage strength for the drug.
     */
    protected $availableStrength;
    /**
     * Breastfeeding Warning
     *
     * @var string Any precaution, guidance, contraindication, etc. related to this drug's use by breastfeeding mothers.
     */
    protected $breastfeedingWarning;
    /**
     * Clincal Pharmacology
     *
     * @var string Description of the absorption and elimination of drugs, including their concentration (pharmacokinetics, pK) and biological effects (pharmacodynamics, pD).
     */
    protected $clincalPharmacology;
    /**
     * Cost
     *
     * @var DrugCost Cost per unit of the drug, as reported by the source being tagged.
     */
    protected $cost;
    /**
     * Dosage Form
     *
     * @var string A dosage form in which this drug/supplement is available, e.g. 'tablet', 'suspension', 'injection'.
     */
    protected $dosageForm;
    /**
     * Dose Schedule
     *
     * @var DoseSchedule A dosing schedule for the drug for a given population, either observed, recommended, or maximum dose based on the type used.
     */
    protected $doseSchedule;
    /**
     * Drug Class
     *
     * @var DrugClass The class of drug this belongs to (e.g., statins).
     */
    protected $drugClass;
    /**
     * Food Warning
     *
     * @var string Any precaution, guidance, contraindication, etc. related to consumption of specific foods while taking this drug.
     */
    protected $foodWarning;
    /**
     * Interacting Drug
     *
     * @var Drug Another drug that is known to interact with this drug in a way that impacts the effect of this drug or causes a risk to the patient. Note: disease interactions are typically captured as contraindications.
     */
    protected $interactingDrug;
    /**
     * Is Available Generically
     *
     * @var boolean True if the drug is available in a generic form (regardless of name).
     */
    protected $isAvailableGenerically;
    /**
     * Is Proprietary
     *
     * @var boolean True if this item's name is a proprietary/brand name (vs. generic name).
     */
    protected $isProprietary;
    /**
     * Label Details
     *
     * @var string Link to the drug's label details.
     */
    protected $labelDetails;
    /**
     * Legal Status
     *
     * @var DrugLegalStatus The drug or supplement's legal status, including any controlled substance schedules that apply.
     */
    protected $legalStatus;
    /**
     * Manufacturer
     *
     * @var Organization The manufacturer of the product.
     */
    protected $manufacturer;
    /**
     * Mechanism of Action
     *
     * @var string The specific biochemical interaction through which this drug or supplement produces its pharmacological effect.
     */
    protected $mechanismOfAction;
    /**
     * Non Proprietary Name
     *
     * @var string The generic name of this drug or supplement.
     */
    protected $nonProprietaryName;
    /**
     * Overdosage
     *
     * @var string Any information related to overdose on a drug, including signs or symptoms, treatments, contact information for emergency response.
     */
    protected $overdosage;
    /**
     * Pregnancy Category
     *
     * @var DrugPregnancyCategory Pregnancy category of this drug.
     */
    protected $pregnancyCategory;
    /**
     * Pregnancy Warning
     *
     * @var string Any precaution, guidance, contraindication, etc. related to this drug's use during pregnancy.
     */
    protected $pregnancyWarning;
    /**
     * Prescribing Info
     *
     * @var string Link to prescribing information for the drug.
     */
    protected $prescribingInfo;
    /**
     * Prescription Status
     *
     * @var DrugPrescriptionStatus Indicates whether this drug is available by prescription or over-the-counter.
     */
    protected $prescriptionStatus;
    /**
     * Related Drug
     *
     * @var Drug Any other drug related to this one, for example commonly-prescribed alternatives.
     */
    protected $relatedDrug;
    /**
     * Warning (Text)
     *
     * @var string Any FDA or other warnings about the drug (text or URL).
     */
    protected $warningText;
    /**
     * Warning (URL)
     *
     * @var string Any FDA or other warnings about the drug (text or URL).
     */
    protected $warningURL;
}
