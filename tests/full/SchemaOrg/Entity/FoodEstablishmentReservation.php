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
     */
    private $endTime;
    /**
     */
    private $startTime;
    /**
     */
    private $partySize;
}
