<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A reservation for an event like a concert, sporting event, or lecture.Note: This type is for information about actual reservations, e.g. in confirmation emails or HTML pages with individual confirmations of reservations. For offers of tickets, use http://schema.org/Offer.
 * 
 * @see http://schema.org/EventReservation Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class EventReservation extends Reservation
{
}
