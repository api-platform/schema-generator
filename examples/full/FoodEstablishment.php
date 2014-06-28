<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Food Establishment
 * 
 * @link http://schema.org/FoodEstablishment
 * 
 * @ORM\MappedSuperclass
 */
class FoodEstablishment extends LocalBusiness
{
    /**
     * Accepts Reservations
     * 
     * @var string $acceptsReservations Either Yes/No, or a URL at which reservations can be made.
     * 
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $acceptsReservations;
    /**
     * Menu
     * 
     * @var string $menu Either the actual menu or a URL of the menu.
     * 
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $menu;
    /**
     * Serves Cuisine
     * 
     * @var string $servesCuisine The cuisine of the restaurant.
     * 
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $servesCuisine;
}
