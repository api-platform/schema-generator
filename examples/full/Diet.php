<?php

namespace SchemaOrg;

/**
 * Diet
 *
 * @link http://schema.org/Diet
 */
class Diet extends CreativeWork
{
    /**
     * Diet Features
     *
     * @var string Nutritional information specific to the dietary plan. May include dietary recommendations on what foods to avoid, what foods to consume, and specific alterations/deviations from the USDA or other regulatory body's approved dietary guidelines.
     */
    protected $dietFeatures;
    /**
     * Endorsers (Organization)
     *
     * @var Organization People or organizations that endorse the plan.
     */
    protected $endorsersOrganization;
    /**
     * Endorsers (Person)
     *
     * @var Person People or organizations that endorse the plan.
     */
    protected $endorsersPerson;
    /**
     * Expert Considerations
     *
     * @var string Medical expert advice related to the plan.
     */
    protected $expertConsiderations;
    /**
     * Overview
     *
     * @var string Descriptive information establishing the overarching theory/philosophy of the plan. May include the rationale for the name, the population where the plan first came to prominence, etc.
     */
    protected $overview;
    /**
     * Physiological Benefits
     *
     * @var string Specific physiologic benefits associated to the plan.
     */
    protected $physiologicalBenefits;
    /**
     * Proprietary Name
     *
     * @var string Proprietary name given to the diet plan, typically by its originator or creator.
     */
    protected $proprietaryName;
    /**
     * Risks
     *
     * @var string Specific physiologic risks associated to the plan.
     */
    protected $risks;
}
