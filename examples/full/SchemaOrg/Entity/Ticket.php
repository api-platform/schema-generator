<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Used to describe a ticket to an event, a flight, a bus ride, etc.
 * 
 * @see http://schema.org/Ticket Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class Ticket extends Intangible
{
    /**
     * @type Person $underName The person or organization the reservation or ticket is for.
     * @ORM\ManyToOne(targetEntity="Person")
     * @ORM\JoinColumn(nullable=false)
     */
    private $underName;
    /**
     * @type float $totalPrice The total price for the reservation or ticket, including applicable taxes, shipping, etc.
     * @Assert\Type(type="float")
     * @ORM\Column(type="float")
     */
    private $totalPrice;
    /**
     * @type string $priceCurrency The currency (in 3-letter ISO 4217 format) of the price or a price component, when attached to PriceSpecification and its subtypes.
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $priceCurrency;
    /**
     * @type Organization $issuedBy The organization issuing the ticket or permit.
     * @ORM\ManyToOne(targetEntity="Organization")
     * @ORM\JoinColumn(nullable=false)
     */
    private $issuedBy;
    /**
     * @type \DateTime $dateIssued The date the ticket was issued.
     * @Assert\DateTime
     * @ORM\Column(type="datetime")
     */
    private $dateIssued;
    /**
     * @type Seat $ticketedSeat The seat associated with the ticket.
     * @ORM\ManyToOne(targetEntity="Seat")
     * @ORM\JoinColumn(nullable=false)
     */
    private $ticketedSeat;
    /**
     * @type string $ticketNumber The unique identifier for the ticket.
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $ticketNumber;
    /**
     * @type string $ticketToken Reference to an asset (e.g., Barcode, QR code image or PDF) usable for entrance.
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $ticketToken;
}
