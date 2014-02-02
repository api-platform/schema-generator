<?php

namespace SchemaOrg;

/**
 * Food Establishment
 *
 * @link http://schema.org/FoodEstablishment
 */
class FoodEstablishment extends LocalBusiness
{
    /**
     * Accepts Reservations (Text)
     *
     * @var string Either <code>Yes/No</code>, or a URL at which reservations can be made.
     */
    protected $acceptsReservationsText;
    /**
     * Accepts Reservations (URL)
     *
     * @var string Either <code>Yes/No</code>, or a URL at which reservations can be made.
     */
    protected $acceptsReservationsURL;
    /**
     * Menu (Text)
     *
     * @var string Either the actual menu or a URL of the menu.
     */
    protected $menuText;
    /**
     * Menu (URL)
     *
     * @var string Either the actual menu or a URL of the menu.
     */
    protected $menuURL;
    /**
     * Serves Cuisine
     *
     * @var string The cuisine of the restaurant.
     */
    protected $servesCuisine;
}
