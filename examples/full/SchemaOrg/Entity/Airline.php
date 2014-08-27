<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * An organization that provides flights for passengers.
 * 
 * @see http://schema.org/Airline Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class Airline extends Organization
{
    /**
     * @type string $iataCode IATA identifier for an airline or airport
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $iataCode;
}
