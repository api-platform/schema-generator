<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A trip on a commercial bus line.
 * 
 * @see http://schema.org/BusTrip Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class BusTrip extends Intangible
{
    /**
     * @type Person $provider The service provider, service operator, or service performer; the goods producer. Another party (a seller) may offer those services or goods on behalf of the provider. A provider may also serve as the seller.
     * @ORM\ManyToOne(targetEntity="Person")
     */
    private $provider;
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
     * @type string $busNumber The unique identifier for the bus.
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $busNumber;
    /**
     * @type string $busName The name of the bus (e.g. Bolt Express).
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $busName;
    /**
     * @type BusStation $departureBusStop The stop or station from which the bus departs.
     * @ORM\ManyToOne(targetEntity="BusStation")
     * @ORM\JoinColumn(nullable=false)
     */
    private $departureBusStop;
    /**
     * @type BusStation $arrivalBusStop The stop or station from which the bus arrives.
     * @ORM\ManyToOne(targetEntity="BusStation")
     * @ORM\JoinColumn(nullable=false)
     */
    private $arrivalBusStop;
}
