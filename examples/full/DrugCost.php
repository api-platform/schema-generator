<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Drug Cost
 * 
 * @link http://schema.org/DrugCost
 * 
 * @ORM\Entity
 */
class DrugCost extends MedicalIntangible
{
    /**
     * Applicable Location
     * 
     * @var AdministrativeArea $applicableLocation The location in which the status applies.
     * 
     * @ORM\ManyToOne(targetEntity="AdministrativeArea")
     * @ORM\JoinColumn(nullable=false)
     */
    private $applicableLocation;
    /**
     * Cost Category
     * 
     * @var DrugCostCategory $costCategory The category of cost, such as wholesale, retail, reimbursement cap, etc.
     * 
     * @ORM\ManyToOne(targetEntity="DrugCostCategory")
     * @ORM\JoinColumn(nullable=false)
     */
    private $costCategory;
    /**
     * Cost Currency
     * 
     * @var string $costCurrency The currency (in 3-letter ISO 4217 format) of the drug cost.
     * 
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $costCurrency;
    /**
     * Cost Origin
     * 
     * @var string $costOrigin Additional details to capture the origin of the cost data. For example, 'Medicare Part B'.
     * 
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $costOrigin;
    /**
     * Cost Per Unit
     * 
     * @var float $costPerUnit The cost per unit of the drug.
     * 
     * @Assert\Type(type="float")
     * @ORM\Column(type="float")
     */
    private $costPerUnit;
    /**
     * Drug Unit
     * 
     * @var string $drugUnit The unit in which the drug is measured, e.g. '5 mg tablet'.
     * 
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $drugUnit;
}
