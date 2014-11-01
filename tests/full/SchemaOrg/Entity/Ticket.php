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
     */
    private $underName;
    /**
     */
    private $totalPrice;
    /**
     */
    private $priceCurrency;
    /**
     */
    private $issuedBy;
    /**
     */
    private $dateIssued;
    /**
     */
    private $ticketedSeat;
    /**
     */
    private $ticketNumber;
    /**
     */
    private $ticketToken;
}
