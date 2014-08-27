<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A reservation for a taxi.Note: This type is for information about actual reservations, e.g. in confirmation emails or HTML pages with individual confirmations of reservations. For offers of tickets, use http://schema.org/Offer.
 * 
 * @see http://schema.org/TaxiReservation Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class TaxiReservation extends Reservation
{
    /**
     * @type float $partySize Number of people the reservation should accommodate.
     * @Assert\Type(type="float")
     * @ORM\Column(type="float")
     */
    private $partySize;
    /**
     * @type Place $pickupLocation Where a taxi will pick up a passenger or a rental car can be picked up.
     */
    private $pickupLocation;
    /**
     * @type \DateTime $pickupTime When a taxi will pickup a passenger or a rental car can be picked up.
     * @Assert\DateTime
     * @ORM\Column(type="datetime")
     */
    private $pickupTime;
}
