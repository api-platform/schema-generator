<?php

namespace SchemaOrg;

/**
 * Nutrition Information
 *
 * @link http://schema.org/NutritionInformation
 */
class NutritionInformation extends StructuredValue
{
    /**
     * Calories
     *
     * @var Energy The number of calories
     */
    protected $calories;
    /**
     * Carbohydrate Content
     *
     * @var Mass The number of grams of carbohydrates.
     */
    protected $carbohydrateContent;
    /**
     * Cholesterol Content
     *
     * @var Mass The number of milligrams of cholesterol.
     */
    protected $cholesterolContent;
    /**
     * Fat Content
     *
     * @var Mass The number of grams of fat.
     */
    protected $fatContent;
    /**
     * Fiber Content
     *
     * @var Mass The number of grams of fiber.
     */
    protected $fiberContent;
    /**
     * Protein Content
     *
     * @var Mass The number of grams of protein.
     */
    protected $proteinContent;
    /**
     * Saturated Fat Content
     *
     * @var Mass The number of grams of saturated fat.
     */
    protected $saturatedFatContent;
    /**
     * Serving Size
     *
     * @var string The serving size, in terms of the number of volume or mass
     */
    protected $servingSize;
    /**
     * Sodium Content
     *
     * @var Mass The number of milligrams of sodium.
     */
    protected $sodiumContent;
    /**
     * Sugar Content
     *
     * @var Mass The number of grams of sugar.
     */
    protected $sugarContent;
    /**
     * Trans Fat Content
     *
     * @var Mass The number of grams of trans fat.
     */
    protected $transFatContent;
    /**
     * Unsaturated Fat Content
     *
     * @var Mass The number of grams of unsaturated fat.
     */
    protected $unsaturatedFatContent;
}
