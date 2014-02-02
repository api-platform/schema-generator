<?php

namespace SchemaOrg;

/**
 * Business Audience
 *
 * @link http://schema.org/BusinessAudience
 */
class BusinessAudience extends Audience
{
    /**
     * Numberof Employees
     *
     * @var QuantitativeValue The size of business by number of employees.
     */
    protected $numberofEmployees;
    /**
     * Yearly Revenue
     *
     * @var QuantitativeValue The size of the business in annual revenue.
     */
    protected $yearlyRevenue;
    /**
     * Years in Operation
     *
     * @var QuantitativeValue The age of the business.
     */
    protected $yearsInOperation;
}
