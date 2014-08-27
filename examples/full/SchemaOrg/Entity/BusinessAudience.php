<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A set of characteristics belonging to businesses, e.g. who compose an item's target audience.
 * 
 * @see http://schema.org/BusinessAudience Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class BusinessAudience extends Audience
{
    /**
     * @type QuantitativeValue $numberofEmployees The size of business by number of employees.
     * @ORM\ManyToOne(targetEntity="QuantitativeValue")
     * @ORM\JoinColumn(nullable=false)
     */
    private $numberofEmployees;
    /**
     * @type QuantitativeValue $yearlyRevenue The size of the business in annual revenue.
     * @ORM\ManyToOne(targetEntity="QuantitativeValue")
     * @ORM\JoinColumn(nullable=false)
     */
    private $yearlyRevenue;
    /**
     * @type QuantitativeValue $yearsInOperation The age of the business.
     * @ORM\ManyToOne(targetEntity="QuantitativeValue")
     * @ORM\JoinColumn(nullable=false)
     */
    private $yearsInOperation;
}
