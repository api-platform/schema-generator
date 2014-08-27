<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A group of multiple reservations with common values for all sub-reservations.
 * 
 * @see http://schema.org/ReservationPackage Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class ReservationPackage extends Reservation
{
    /**
     * @type Reservation $subReservation The individual reservations included in the package. Typically a repeated property.
     * @ORM\ManyToOne(targetEntity="Reservation")
     * @ORM\JoinColumn(nullable=false)
     */
    private $subReservation;
}
