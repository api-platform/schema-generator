<?php

namespace SchemaOrg;

/**
 * Drug Cost
 *
 * @link http://schema.org/DrugCost
 */
class DrugCost extends MedicalIntangible
{
    /**
     * Applicable Location
     *
     * @var AdministrativeArea The location in which the status applies.
     */
    protected $applicableLocation;
    /**
     * Cost Category
     *
     * @var DrugCostCategory The category of cost, such as wholesale, retail, reimbursement cap, etc.
     */
    protected $costCategory;
    /**
     * Cost Currency
     *
     * @var string The currency (in 3-letter <a href="http://en.wikipedia.org/wiki/ISO_4217">ISO 4217 format</a>) of the drug cost.
     */
    protected $costCurrency;
    /**
     * Cost Origin
     *
     * @var string Additional details to capture the origin of the cost data. For example, 'Medicare Part B'.
     */
    protected $costOrigin;
    /**
     * Cost Per Unit (Number)
     *
     * @var float The cost per unit of the drug.
     */
    protected $costPerUnitNumber;
    /**
     * Cost Per Unit (Text)
     *
     * @var string The cost per unit of the drug.
     */
    protected $costPerUnitText;
    /**
     * Drug Unit
     *
     * @var string The unit in which the drug is measured, e.g. '5 mg tablet'.
     */
    protected $drugUnit;
}
