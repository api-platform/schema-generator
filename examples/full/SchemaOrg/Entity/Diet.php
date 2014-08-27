<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A strategy of regulating the intake of food to achieve or maintain a specific health-related goal.
 * 
 * @see http://schema.org/Diet Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class Diet extends CreativeWork
{
    /**
     * @type string $dietFeatures Nutritional information specific to the dietary plan. May include dietary recommendations on what foods to avoid, what foods to consume, and specific alterations/deviations from the USDA or other regulatory body's approved dietary guidelines.
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $dietFeatures;
    /**
     * @type Organization $endorsers People or organizations that endorse the plan.
     */
    private $endorsers;
    /**
     * @type string $expertConsiderations Medical expert advice related to the plan.
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $expertConsiderations;
    /**
     * @type string $overview Descriptive information establishing the overarching theory/philosophy of the plan. May include the rationale for the name, the population where the plan first came to prominence, etc.
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $overview;
    /**
     * @type string $physiologicalBenefits Specific physiologic benefits associated to the plan.
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $physiologicalBenefits;
    /**
     * @type string $proprietaryName Proprietary name given to the diet plan, typically by its originator or creator.
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $proprietaryName;
    /**
     * @type string $risks Specific physiologic risks associated to the plan.
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $risks;
}
