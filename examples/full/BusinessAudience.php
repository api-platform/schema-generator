<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Business Audience
 * 
 * @link http://schema.org/BusinessAudience
 * 
 * @ORM\Entity
 */
class BusinessAudience extends Audience
{
    /**
     * Numberof Employees
     * 
     * @var QuantitativeValue $numberofEmployees The size of business by number of employees.
     * 
     * @ORM\ManyToOne(targetEntity="QuantitativeValue")
     * @ORM\JoinColumn(nullable=false)
     */
    private $numberofEmployees;
    /**
     * Yearly Revenue
     * 
     * @var QuantitativeValue $yearlyRevenue The size of the business in annual revenue.
     * 
     * @ORM\ManyToOne(targetEntity="QuantitativeValue")
     * @ORM\JoinColumn(nullable=false)
     */
    private $yearlyRevenue;
    /**
     * Years in Operation
     * 
     * @var QuantitativeValue $yearsInOperation The age of the business.
     * 
     * @ORM\ManyToOne(targetEntity="QuantitativeValue")
     * @ORM\JoinColumn(nullable=false)
     */
    private $yearsInOperation;
}
