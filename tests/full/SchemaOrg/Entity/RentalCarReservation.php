<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A reservation for a rental car.Note: This type is for information about actual reservations, e.g. in confirmation emails or HTML pages with individual confirmations of reservations.
 * 
 * @see http://schema.org/RentalCarReservation Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class RentalCarReservation extends Reservation
{
    /**
     */
    private $pickupLocation;
    /**
     */
    private $dropoffLocation;
    /**
     */
    private $pickupTime;
    /**
     */
    private $dropoffTime;
}
