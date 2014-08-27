<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A recipe.
 * 
 * @see http://schema.org/Recipe Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class Recipe extends CreativeWork
{
    /**
     * @type string $cookingMethod The method of cooking, such as Frying, Steaming, ...
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $cookingMethod;
    /**
     * @type Duration $cookTime The time it takes to actually cook the dish, in <a href='http://en.wikipedia.org/wiki/ISO_8601'>ISO 8601 duration format</a>.
     * @ORM\ManyToOne(targetEntity="Duration")
     * @ORM\JoinColumn(nullable=false)
     */
    private $cookTime;
    /**
     * @type string $ingredients An ingredient used in the recipe.
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $ingredients;
    /**
     * @type NutritionInformation $nutrition Nutrition information about the recipe.
     */
    private $nutrition;
    /**
     * @type Duration $prepTime The length of time it takes to prepare the recipe, in <a href='http://en.wikipedia.org/wiki/ISO_8601'>ISO 8601 duration format</a>.
     * @ORM\ManyToOne(targetEntity="Duration")
     * @ORM\JoinColumn(nullable=false)
     */
    private $prepTime;
    /**
     * @type string $recipeCategory The category of the recipe&#x2014;for example, appetizer, entree, etc.
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $recipeCategory;
    /**
     * @type string $recipeCuisine The cuisine of the recipe (for example, French or Ethiopian).
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $recipeCuisine;
    /**
     * @type string $recipeInstructions The steps to make the dish.
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $recipeInstructions;
    /**
     * @type string $recipeYield The quantity produced by the recipe (for example, number of people served, number of servings, etc).
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $recipeYield;
    /**
     * @type Duration $totalTime The total time it takes to prepare and cook the recipe, in <a href='http://en.wikipedia.org/wiki/ISO_8601'>ISO 8601 duration format</a>.
     * @ORM\ManyToOne(targetEntity="Duration")
     * @ORM\JoinColumn(nullable=false)
     */
    private $totalTime;
}
