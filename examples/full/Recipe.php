<?php

namespace SchemaOrg;

/**
 * Recipe
 *
 * @link http://schema.org/Recipe
 */
class Recipe extends CreativeWork
{
    /**
     * Cooking Method
     *
     * @var string The method of cooking, such as Frying, Steaming, ...
     */
    protected $cookingMethod;
    /**
     * Cook Time
     *
     * @var Duration The time it takes to actually cook the dish, in <a href="http://en.wikipedia.org/wiki/ISO_8601">ISO 8601 duration format</a>.
     */
    protected $cookTime;
    /**
     * Ingredients
     *
     * @var string An ingredient used in the recipe.
     */
    protected $ingredients;
    /**
     * Nutrition
     *
     * @var NutritionInformation Nutrition information about the recipe.
     */
    protected $nutrition;
    /**
     * Prep Time
     *
     * @var Duration The length of time it takes to prepare the recipe, in <a href="http://en.wikipedia.org/wiki/ISO_8601">ISO 8601 duration format</a>.
     */
    protected $prepTime;
    /**
     * Recipe Category
     *
     * @var string The category of the recipe—for example, appetizer, entree, etc.
     */
    protected $recipeCategory;
    /**
     * Recipe Cuisine
     *
     * @var string The cuisine of the recipe (for example, French or Ethopian).
     */
    protected $recipeCuisine;
    /**
     * Recipe Instructions
     *
     * @var string The steps to make the dish.
     */
    protected $recipeInstructions;
    /**
     * Recipe Yield
     *
     * @var string The quantity produced by the recipe (for example, number of people served, number of servings, etc).
     */
    protected $recipeYield;
    /**
     * Total Time
     *
     * @var Duration The total time it takes to prepare and cook the recipe, in <a href="http://en.wikipedia.org/wiki/ISO_8601">ISO 8601 duration format</a>.
     */
    protected $totalTime;
}
