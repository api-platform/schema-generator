<?php

namespace SchemaOrg;

/**
 * Cook Action
 *
 * @link http://schema.org/CookAction
 */
class CookAction extends CreateAction
{
    /**
     * Food Establishment (FoodEstablishment)
     *
     * @var FoodEstablishment A sub property of location. The specific food establishment where the action occurreed.
     */
    protected $foodEstablishmentFoodEstablishment;
    /**
     * Food Establishment (Place)
     *
     * @var Place A sub property of location. The specific food establishment where the action occurreed.
     */
    protected $foodEstablishmentPlace;
    /**
     * Food Event
     *
     * @var FoodEvent A sub property of location. The specific food event where the action occurred.
     */
    protected $foodEvent;
    /**
     * Recipe
     *
     * @var Recipe A sub property of instrument. The recipe/instructions used to perform the action.
     */
    protected $recipe;
}
