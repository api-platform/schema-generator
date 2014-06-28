<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Recipe
 * 
 * @link http://schema.org/Recipe
 * 
 * @ORM\Entity
 */
class Recipe extends CreativeWork
{
    /**
     * Cooking Method
     * 
     * @var string $cookingMethod The method of cooking, such as Frying, Steaming, ...
     * 
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $cookingMethod;
    /**
     * Cook Time
     * 
     * @var Duration $cookTime The time it takes to actually cook the dish, in ISO 8601 duration format.
     * 
     * @ORM\ManyToOne(targetEntity="Duration")
     * @ORM\JoinColumn(nullable=false)
     */
    private $cookTime;
    /**
     * Ingredients
     * 
     * @var string $ingredients An ingredient used in the recipe.
     * 
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $ingredients;
    /**
     * Nutrition
     * 
     * @var NutritionInformation $nutrition Nutrition information about the recipe.
     * 
     */
    private $nutrition;
    /**
     * Prep Time
     * 
     * @var Duration $prepTime The length of time it takes to prepare the recipe, in ISO 8601 duration format.
     * 
     * @ORM\ManyToOne(targetEntity="Duration")
     * @ORM\JoinColumn(nullable=false)
     */
    private $prepTime;
    /**
     * Recipe Category
     * 
     * @var string $recipeCategory The category of the recipe—for example, appetizer, entree, etc.
     * 
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $recipeCategory;
    /**
     * Recipe Cuisine
     * 
     * @var string $recipeCuisine The cuisine of the recipe (for example, French or Ethopian).
     * 
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $recipeCuisine;
    /**
     * Recipe Instructions
     * 
     * @var string $recipeInstructions The steps to make the dish.
     * 
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $recipeInstructions;
    /**
     * Recipe Yield
     * 
     * @var string $recipeYield The quantity produced by the recipe (for example, number of people served, number of servings, etc).
     * 
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $recipeYield;
    /**
     * Total Time
     * 
     * @var Duration $totalTime The total time it takes to prepare and cook the recipe, in ISO 8601 duration format.
     * 
     * @ORM\ManyToOne(targetEntity="Duration")
     * @ORM\JoinColumn(nullable=false)
     */
    private $totalTime;
}
