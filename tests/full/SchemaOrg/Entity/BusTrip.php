<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A trip on a commercial bus line.
 * 
 * @see http://schema.org/BusTrip Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class BusTrip extends Intangible
{
    /**
     */
    private $provider;
    /**
     */
    private $departureTime;
    /**
     */
    private $arrivalTime;
    /**
     */
    private $busNumber;
    /**
     */
    private $busName;
    /**
     */
    private $departureBusStop;
    /**
     */
    private $arrivalBusStop;
}
