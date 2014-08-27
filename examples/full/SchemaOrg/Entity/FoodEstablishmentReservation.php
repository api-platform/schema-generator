<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A reservation to dine at a food-related business.Note: This type is for information about actual reservations, e.g. in confirmation emails or HTML pages with individual confirmations of reservations.
 * 
 * @see http://schema.org/FoodEstablishmentReservation Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class FoodEstablishmentReservation extends Reservation
{
    /**
     * @type \DateTime $endTime The endTime of something. For a reserved event or service (e.g. FoodEstablishmentReservation), the time that it is expected to end. For actions that span a period of time, when the action was performed. e.g. John wrote a book from January to *December*.

Note that Event uses startDate/endDate instead of startTime/endTime, even when describing dates with times. This situation may be clarified in future revisions.

     * @Assert\DateTime
     * @ORM\Column(type="datetime")
     */
    private $endTime;
    /**
     * @type \DateTime $startTime The startTime of something. For a reserved event or service (e.g. FoodEstablishmentReservation), the time that it is expected to start. For actions that span a period of time, when the action was performed. e.g. John wrote a book from *January* to December.

Note that Event uses startDate/endDate instead of startTime/endTime, even when describing dates with times. This situation may be clarified in future revisions.

     * @Assert\DateTime
     * @ORM\Column(type="datetime")
     */
    private $startTime;
    /**
     * @type float $partySize Number of people the reservation should accommodate.
     * @Assert\Type(type="float")
     * @ORM\Column(type="float")
     */
    private $partySize;
}
