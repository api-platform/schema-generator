<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Used to describe a seat, such as a reserved seat in an event reservation.
 * 
 * @see http://schema.org/Seat Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class Seat extends Intangible
{
    /**
     * @type string $seatNumber The location of the reserved seat (e.g., 27).
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $seatNumber;
    /**
     * @type string $seatRow The row location of the reserved seat (e.g., B).
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $seatRow;
    /**
     * @type string $seatSection The section location of the reserved seat (e.g. Orchestra).
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $seatSection;
    /**
     * @type string $seatingType The type/class of the seat.
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $seatingType;
}
