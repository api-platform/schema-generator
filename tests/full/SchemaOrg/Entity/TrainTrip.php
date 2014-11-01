<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A trip on a commercial train line.
 * 
 * @see http://schema.org/TrainTrip Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class TrainTrip extends Intangible
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
    private $trainNumber;
    /**
     */
    private $trainName;
    /**
     */
    private $departureStation;
    /**
     */
    private $arrivalStation;
    /**
     */
    private $departurePlatform;
    /**
     */
    private $arrivalPlatform;
}
