<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Nutritional information about the recipe.
 * 
 * @see http://schema.org/NutritionInformation Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class NutritionInformation extends StructuredValue
{
    /**
     * @type Energy $calories The number of calories
     * @ORM\ManyToOne(targetEntity="Energy")
     * @ORM\JoinColumn(nullable=false)
     */
    private $calories;
    /**
     * @type Mass $carbohydrateContent The number of grams of carbohydrates.
     * @ORM\ManyToOne(targetEntity="Mass")
     * @ORM\JoinColumn(nullable=false)
     */
    private $carbohydrateContent;
    /**
     * @type Mass $cholesterolContent The number of milligrams of cholesterol.
     * @ORM\ManyToOne(targetEntity="Mass")
     * @ORM\JoinColumn(nullable=false)
     */
    private $cholesterolContent;
    /**
     * @type Mass $fatContent The number of grams of fat.
     * @ORM\ManyToOne(targetEntity="Mass")
     * @ORM\JoinColumn(nullable=false)
     */
    private $fatContent;
    /**
     * @type Mass $fiberContent The number of grams of fiber.
     * @ORM\ManyToOne(targetEntity="Mass")
     * @ORM\JoinColumn(nullable=false)
     */
    private $fiberContent;
    /**
     * @type Mass $proteinContent The number of grams of protein.
     * @ORM\ManyToOne(targetEntity="Mass")
     * @ORM\JoinColumn(nullable=false)
     */
    private $proteinContent;
    /**
     * @type Mass $saturatedFatContent The number of grams of saturated fat.
     * @ORM\ManyToOne(targetEntity="Mass")
     * @ORM\JoinColumn(nullable=false)
     */
    private $saturatedFatContent;
    /**
     * @type string $servingSize The serving size, in terms of the number of volume or mass.
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $servingSize;
    /**
     * @type Mass $sodiumContent The number of milligrams of sodium.
     * @ORM\ManyToOne(targetEntity="Mass")
     * @ORM\JoinColumn(nullable=false)
     */
    private $sodiumContent;
    /**
     * @type Mass $sugarContent The number of grams of sugar.
     * @ORM\ManyToOne(targetEntity="Mass")
     * @ORM\JoinColumn(nullable=false)
     */
    private $sugarContent;
    /**
     * @type Mass $transFatContent The number of grams of trans fat.
     * @ORM\ManyToOne(targetEntity="Mass")
     * @ORM\JoinColumn(nullable=false)
     */
    private $transFatContent;
    /**
     * @type Mass $unsaturatedFatContent The number of grams of unsaturated fat.
     * @ORM\ManyToOne(targetEntity="Mass")
     * @ORM\JoinColumn(nullable=false)
     */
    private $unsaturatedFatContent;
}
