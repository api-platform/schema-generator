<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * An airline flight.
 * 
 * @see http://schema.org/Flight Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class Flight extends Intangible
{
    /**
     */
    private $carrier;
    /**
     */
    private $seller;
    /**
     */
    private $provider;
    /**
     */
    private $flightNumber;
    /**
     */
    private $departureTime;
    /**
     */
    private $arrivalTime;
    /**
     */
    private $departureAirport;
    /**
     */
    private $arrivalAirport;
    /**
     */
    private $departureGate;
    /**
     */
    private $arrivalGate;
    /**
     */
    private $departureTerminal;
    /**
     */
    private $arrivalTerminal;
    /**
     */
    private $aircraft;
    /**
     */
    private $mealService;
    /**
     */
    private $estimatedFlightDuration;
    /**
     */
    private $flightDistance;
    /**
     */
    private $webCheckinTime;
}
