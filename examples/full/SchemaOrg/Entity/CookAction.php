<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * The act of producing/preparing food.
 * 
 * @see http://schema.org/CookAction Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class CookAction extends CreateAction
{
    /**
     * @type FoodEstablishment $foodEstablishment A sub property of location. The specific food establishment where the action occurred.
     * @ORM\ManyToOne(targetEntity="FoodEstablishment")
     */
    private $foodEstablishment;
    /**
     * @type FoodEvent $foodEvent A sub property of location. The specific food event where the action occurred.
     * @ORM\ManyToOne(targetEntity="FoodEvent")
     */
    private $foodEvent;
    /**
     * @type Recipe $recipe A sub property of instrument. The recipe/instructions used to perform the action.
     * @ORM\ManyToOne(targetEntity="Recipe")
     */
    private $recipe;
}
