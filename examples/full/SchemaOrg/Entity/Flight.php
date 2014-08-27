<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * An airline flight.
 * 
 * @see http://schema.org/Flight Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class Flight extends Intangible
{
    /**
     * @type Organization $carrier 'carrier' is an out-dated term indicating the 'provider' for parcel delivery and flights.
     */
    private $carrier;
    /**
     * @type Organization $seller An entity which offers (sells / leases / lends / loans) the services / goods.  A seller may also be a provider.
     * @ORM\ManyToOne(targetEntity="Organization")
     */
    private $seller;
    /**
     * @type Person $provider The service provider, service operator, or service performer; the goods producer. Another party (a seller) may offer those services or goods on behalf of the provider. A provider may also serve as the seller.
     * @ORM\ManyToOne(targetEntity="Person")
     */
    private $provider;
    /**
     * @type string $flightNumber The unique identifier for a flight including the airline IATA code. For example, if describing United flight 110, where the IATA code for United is 'UA', the flightNumber is 'UA110'.
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $flightNumber;
    /**
     * @type \DateTime $departureTime The expected departure time.
     * @Assert\DateTime
     * @ORM\Column(type="datetime")
     */
    private $departureTime;
    /**
     * @type \DateTime $arrivalTime The expected arrival time.
     * @Assert\DateTime
     * @ORM\Column(type="datetime")
     */
    private $arrivalTime;
    /**
     * @type Airport $departureAirport The airport where the flight originates.
     * @ORM\ManyToOne(targetEntity="Airport")
     * @ORM\JoinColumn(nullable=false)
     */
    private $departureAirport;
    /**
     * @type Airport $arrivalAirport The airport where the flight terminates.
     * @ORM\ManyToOne(targetEntity="Airport")
     * @ORM\JoinColumn(nullable=false)
     */
    private $arrivalAirport;
    /**
     * @type string $departureGate Identifier of the flight's departure gate.
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $departureGate;
    /**
     * @type string $arrivalGate Identifier of the flight's arrival gate.
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $arrivalGate;
    /**
     * @type string $departureTerminal Identifier of the flight's departure terminal.
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $departureTerminal;
    /**
     * @type string $arrivalTerminal Identifier of the flight's arrival terminal.
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $arrivalTerminal;
    /**
     * @type string $aircraft The kind of aircraft (e.g., "Boeing 747").
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $aircraft;
    /**
     * @type string $mealService Description of the meals that will be provided or available for purchase.
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $mealService;
    /**
     * @type string $estimatedFlightDuration The estimated time the flight will take.
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $estimatedFlightDuration;
    /**
     * @type string $flightDistance The distance of the flight.
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $flightDistance;
    /**
     * @type \DateTime $webCheckinTime The time when a passenger can check into the flight online.
     * @Assert\DateTime
     * @ORM\Column(type="datetime")
     */
    private $webCheckinTime;
}
