<?php

namespace SchemaOrg;

/**
 * Dietary Supplement
 *
 * @link http://schema.org/DietarySupplement
 */
class DietarySupplement extends MedicalTherapy
{
    /**
     * Active Ingredient
     *
     * @var string An active ingredient, typically chemical compounds and/or biologic substances.
     */
    protected $activeIngredient;
    /**
     * Background
     *
     * @var string Descriptive information establishing a historical perspective on the supplement. May include the rationale for the name, the population where the supplement first came to prominence, etc.
     */
    protected $background;
    /**
     * Dosage Form
     *
     * @var string A dosage form in which this drug/supplement is available, e.g. 'tablet', 'suspension', 'injection'.
     */
    protected $dosageForm;
    /**
     * Is Proprietary
     *
     * @var boolean True if this item's name is a proprietary/brand name (vs. generic name).
     */
    protected $isProprietary;
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
     * Maximum Intake
     *
     * @var MaximumDoseSchedule Recommended intake of this supplement for a given population as defined by a specific recommending authority.
     */
    protected $maximumIntake;
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
     * Recommended Intake
     *
     * @var RecommendedDoseSchedule Recommended intake of this supplement for a given population as defined by a specific recommending authority.
     */
    protected $recommendedIntake;
    /**
     * Safety Consideration
     *
     * @var string Any potential safety concern associated with the supplement. May include interactions with other drugs and foods, pregnancy, breastfeeding, known adverse reactions, and documented efficacy of the supplement.
     */
    protected $safetyConsideration;
    /**
     * Target Population
     *
     * @var string Characteristics of the population for which this is intended, or which typically uses it, e.g. 'adults'.
     */
    protected $targetPopulation;
}
