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
     * @type \DateTime $checkinTime The earliest someone may check into a lodging establishment.
     * @Assert\DateTime
     * @ORM\Column(type="datetime")
     */
    private $checkinTime;
    /**
     * @type \DateTime $checkoutTime The latest someone may check out of a lodging establishment.
     * @Assert\DateTime
     * @ORM\Column(type="datetime")
     */
    private $checkoutTime;
    /**
     * @type string $lodgingUnitType Textual description of the unit type (including suite vs. room, size of bed, etc.).
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $lodgingUnitType;
    /**
     * @type string $lodgingUnitDescription A full description of the lodging unit.
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $lodgingUnitDescription;
    /**
     * @type float $numAdults The number of adults staying in the unit.
     * @Assert\Type(type="float")
     * @ORM\Column(type="float")
     */
    private $numAdults;
    /**
     * @type float $numChildren The number of children staying in the unit.
     * @Assert\Type(type="float")
     * @ORM\Column(type="float")
     */
    private $numChildren;
}
