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
     * @type Place $pickupLocation Where a taxi will pick up a passenger or a rental car can be picked up.
     */
    private $pickupLocation;
    /**
     * @type Place $dropoffLocation Where a rental car can be dropped off.
     */
    private $dropoffLocation;
    /**
     * @type \DateTime $pickupTime When a taxi will pickup a passenger or a rental car can be picked up.
     * @Assert\DateTime
     * @ORM\Column(type="datetime")
     */
    private $pickupTime;
    /**
     * @type \DateTime $dropoffTime When a rental car can be dropped off.
     * @Assert\DateTime
     * @ORM\Column(type="datetime")
     */
    private $dropoffTime;
}
