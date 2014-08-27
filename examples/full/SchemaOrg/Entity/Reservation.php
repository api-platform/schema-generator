<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Describes a reservation for travel, dining or an event. Some reservations require tickets.Note: This type is for information about actual reservations, e.g. in confirmation emails or HTML pages with individual confirmations of reservations. For offers of tickets, restaurant reservations, flights, or rental cars, use http://schema.org/Offer.
 * 
 * @see http://schema.org/Reservation Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class Reservation extends Intangible
{
    /**
     * @type string $reservationId A unique identifier for the reservation.
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $reservationId;
    /**
     * @type ReservationStatusType $reservationStatus The current status of the reservation.
     * @ORM\ManyToOne(targetEntity="ReservationStatusType")
     * @ORM\JoinColumn(nullable=false)
     */
    private $reservationStatus;
    /**
     * @type Thing $reservationFor The thing -- flight, event, restaurant,etc. being reserved.
     * @ORM\ManyToOne(targetEntity="Thing")
     * @ORM\JoinColumn(nullable=false)
     */
    private $reservationFor;
    /**
     * @type Person $underName The person or organization the reservation or ticket is for.
     * @ORM\ManyToOne(targetEntity="Person")
     * @ORM\JoinColumn(nullable=false)
     */
    private $underName;
    /**
     * @type Person $provider The service provider, service operator, or service performer; the goods producer. Another party (a seller) may offer those services or goods on behalf of the provider. A provider may also serve as the seller.
     * @ORM\ManyToOne(targetEntity="Person")
     */
    private $provider;
    /**
     * @type Person $bookingAgent 'bookingAgent' is an out-dated term indicating a 'broker' that serves as a booking agent.
     */
    private $bookingAgent;
    /**
     * @type \DateTime $bookingTime The date and time the reservation was booked.
     * @Assert\DateTime
     * @ORM\Column(type="datetime")
     */
    private $bookingTime;
    /**
     * @type \DateTime $modifiedTime The date and time the reservation was modified.
     * @Assert\DateTime
     * @ORM\Column(type="datetime")
     */
    private $modifiedTime;
    /**
     * @type ProgramMembership $programMembershipUsed Any membership in a frequent flyer, hotel loyalty program, etc. being applied to the reservation.
     */
    private $programMembershipUsed;
    /**
     * @type Ticket $reservedTicket A ticket associated with the reservation.
     * @ORM\ManyToOne(targetEntity="Ticket")
     */
    private $reservedTicket;
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
     * @type Person $broker An entity that arranges for an exchange between a buyer and a seller.  In most cases a broker never acquires or releases ownership of a product or service involved in an exchange.  If it is not clear whether an entity is a broker, seller, or buyer, the latter two terms are preferred.
     * @ORM\ManyToOne(targetEntity="Person")
     */
    private $broker;
}
