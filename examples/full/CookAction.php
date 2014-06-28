<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Cook Action
 * 
 * @link http://schema.org/CookAction
 * 
 * @ORM\Entity
 */
class CookAction extends CreateAction
{
    /**
     * Food Establishment
     * 
     * @var FoodEstablishment $foodEstablishment A sub property of location. The specific food establishment where the action occurreed.
     * 
     * @ORM\ManyToOne(targetEntity="FoodEstablishment")
     */
    private $foodEstablishment;
    /**
     * Food Event
     * 
     * @var FoodEvent $foodEvent A sub property of location. The specific food event where the action occurred.
     * 
     * @ORM\ManyToOne(targetEntity="FoodEvent")
     */
    private $foodEvent;
    /**
     * Recipe
     * 
     * @var Recipe $recipe A sub property of instrument. The recipe/instructions used to perform the action.
     * 
     * @ORM\ManyToOne(targetEntity="Recipe")
     */
    private $recipe;
}
