<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Diet
 * 
 * @link http://schema.org/Diet
 * 
 * @ORM\Entity
 */
class Diet extends CreativeWork
{
    /**
     * Diet Features
     * 
     * @var string $dietFeatures Nutritional information specific to the dietary plan. May include dietary recommendations on what foods to avoid, what foods to consume, and specific alterations/deviations from the USDA or other regulatory body's approved dietary guidelines.
     * 
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $dietFeatures;
    /**
     * Endorsers
     * 
     * @var Organization $endorsers People or organizations that endorse the plan.
     * 
     */
    private $endorsers;
    /**
     * Expert Considerations
     * 
     * @var string $expertConsiderations Medical expert advice related to the plan.
     * 
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $expertConsiderations;
    /**
     * Overview
     * 
     * @var string $overview Descriptive information establishing the overarching theory/philosophy of the plan. May include the rationale for the name, the population where the plan first came to prominence, etc.
     * 
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $overview;
    /**
     * Physiological Benefits
     * 
     * @var string $physiologicalBenefits Specific physiologic benefits associated to the plan.
     * 
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $physiologicalBenefits;
    /**
     * Proprietary Name
     * 
     * @var string $proprietaryName Proprietary name given to the diet plan, typically by its originator or creator.
     * 
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $proprietaryName;
    /**
     * Risks
     * 
     * @var string $risks Specific physiologic risks associated to the plan.
     * 
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $risks;
}
