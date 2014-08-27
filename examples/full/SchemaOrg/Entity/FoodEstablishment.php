<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A food-related business.
 * 
 * @see http://schema.org/FoodEstablishment Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class FoodEstablishment extends LocalBusiness
{
    /**
     * @type string $acceptsReservations Indicates whether a FoodEstablishment accepts reservations. Values can be Boolean, an URL at which reservations can be made or (for backwards compatibility) the strings <code>Yes</code> or <code>No</code>.
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $acceptsReservations;
    /**
     * @type string $menu Either the actual menu or a URL of the menu.
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $menu;
    /**
     * @type string $servesCuisine The cuisine of the restaurant.
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $servesCuisine;
}
