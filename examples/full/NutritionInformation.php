<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Nutrition Information
 * 
 * @link http://schema.org/NutritionInformation
 * 
 * @ORM\Entity
 */
class NutritionInformation extends StructuredValue
{
    /**
     * Calories
     * 
     * @var Energy $calories The number of calories
     * 
     * @ORM\ManyToOne(targetEntity="Energy")
     * @ORM\JoinColumn(nullable=false)
     */
    private $calories;
    /**
     * Carbohydrate Content
     * 
     * @var Mass $carbohydrateContent The number of grams of carbohydrates.
     * 
     * @ORM\ManyToOne(targetEntity="Mass")
     * @ORM\JoinColumn(nullable=false)
     */
    private $carbohydrateContent;
    /**
     * Cholesterol Content
     * 
     * @var Mass $cholesterolContent The number of milligrams of cholesterol.
     * 
     * @ORM\ManyToOne(targetEntity="Mass")
     * @ORM\JoinColumn(nullable=false)
     */
    private $cholesterolContent;
    /**
     * Fat Content
     * 
     * @var Mass $fatContent The number of grams of fat.
     * 
     * @ORM\ManyToOne(targetEntity="Mass")
     * @ORM\JoinColumn(nullable=false)
     */
    private $fatContent;
    /**
     * Fiber Content
     * 
     * @var Mass $fiberContent The number of grams of fiber.
     * 
     * @ORM\ManyToOne(targetEntity="Mass")
     * @ORM\JoinColumn(nullable=false)
     */
    private $fiberContent;
    /**
     * Protein Content
     * 
     * @var Mass $proteinContent The number of grams of protein.
     * 
     * @ORM\ManyToOne(targetEntity="Mass")
     * @ORM\JoinColumn(nullable=false)
     */
    private $proteinContent;
    /**
     * Saturated Fat Content
     * 
     * @var Mass $saturatedFatContent The number of grams of saturated fat.
     * 
     * @ORM\ManyToOne(targetEntity="Mass")
     * @ORM\JoinColumn(nullable=false)
     */
    private $saturatedFatContent;
    /**
     * Serving Size
     * 
     * @var string $servingSize The serving size, in terms of the number of volume or mass
     * 
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $servingSize;
    /**
     * Sodium Content
     * 
     * @var Mass $sodiumContent The number of milligrams of sodium.
     * 
     * @ORM\ManyToOne(targetEntity="Mass")
     * @ORM\JoinColumn(nullable=false)
     */
    private $sodiumContent;
    /**
     * Sugar Content
     * 
     * @var Mass $sugarContent The number of grams of sugar.
     * 
     * @ORM\ManyToOne(targetEntity="Mass")
     * @ORM\JoinColumn(nullable=false)
     */
    private $sugarContent;
    /**
     * Trans Fat Content
     * 
     * @var Mass $transFatContent The number of grams of trans fat.
     * 
     * @ORM\ManyToOne(targetEntity="Mass")
     * @ORM\JoinColumn(nullable=false)
     */
    private $transFatContent;
    /**
     * Unsaturated Fat Content
     * 
     * @var Mass $unsaturatedFatContent The number of grams of unsaturated fat.
     * 
     * @ORM\ManyToOne(targetEntity="Mass")
     * @ORM\JoinColumn(nullable=false)
     */
    private $unsaturatedFatContent;
}
