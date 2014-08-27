<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * The cost per unit of a medical drug. Note that this type is not meant to represent the price in an offer of a drug for sale; see the Offer type for that. This type will typically be used to tag wholesale or average retail cost of a drug, or maximum reimbursable cost. Costs of medical drugs vary widely depending on how and where they are paid for, so while this type captures some of the variables, costs should be used with caution by consumers of this schema's markup.
 * 
 * @see http://schema.org/DrugCost Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class DrugCost extends MedicalIntangible
{
    /**
     * @type AdministrativeArea $applicableLocation The location in which the status applies.
     * @ORM\ManyToOne(targetEntity="AdministrativeArea")
     * @ORM\JoinColumn(nullable=false)
     */
    private $applicableLocation;
    /**
     * @type DrugCostCategory $costCategory The category of cost, such as wholesale, retail, reimbursement cap, etc.
     * @ORM\ManyToOne(targetEntity="DrugCostCategory")
     * @ORM\JoinColumn(nullable=false)
     */
    private $costCategory;
    /**
     * @type string $costCurrency The currency (in 3-letter <a href=http://en.wikipedia.org/wiki/ISO_4217>ISO 4217 format</a>) of the drug cost.
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $costCurrency;
    /**
     * @type string $costOrigin Additional details to capture the origin of the cost data. For example, 'Medicare Part B'.
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $costOrigin;
    /**
     * @type float $costPerUnit The cost per unit of the drug.
     * @Assert\Type(type="float")
     * @ORM\Column(type="float")
     */
    private $costPerUnit;
    /**
     * @type string $drugUnit The unit in which the drug is measured, e.g. '5 mg tablet'.
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $drugUnit;
}
