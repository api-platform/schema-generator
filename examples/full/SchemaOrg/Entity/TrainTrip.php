<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A trip on a commercial train line.
 * 
 * @see http://schema.org/TrainTrip Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class TrainTrip extends Intangible
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
     * @type string $trainNumber The unique identifier for the train.
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $trainNumber;
    /**
     * @type string $trainName The name of the train (e.g. The Orient Express).
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $trainName;
    /**
     * @type TrainStation $departureStation The station from which the train departs.
     * @ORM\ManyToOne(targetEntity="TrainStation")
     * @ORM\JoinColumn(nullable=false)
     */
    private $departureStation;
    /**
     * @type TrainStation $arrivalStation The station where the train trip ends.
     * @ORM\ManyToOne(targetEntity="TrainStation")
     * @ORM\JoinColumn(nullable=false)
     */
    private $arrivalStation;
    /**
     * @type string $departurePlatform The platform from which the train departs.
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $departurePlatform;
    /**
     * @type string $arrivalPlatform The platform where the train arrives.
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $arrivalPlatform;
}
