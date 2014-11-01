<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A reservation for lodging at a hotel, motel, inn, etc.Note: This type is for information about actual reservations, e.g. in confirmation emails or HTML pages with individual confirmations of reservations.
 * 
 * @see http://schema.org/LodgingReservation Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class LodgingReservation extends Reservation
{
    /**
     */
    private $checkinTime;
    /**
     */
    private $checkoutTime;
    /**
     */
    private $lodgingUnitType;
    /**
     */
    private $lodgingUnitDescription;
    /**
     */
    private $numAdults;
    /**
     */
    private $numChildren;
}
