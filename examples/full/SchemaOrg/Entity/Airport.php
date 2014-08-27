<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * An airport.
 * 
 * @see http://schema.org/Airport Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class Airport extends CivicStructure
{
    /**
     * @type string $iataCode IATA identifier for an airline or airport
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $iataCode;
    /**
     * @type string $icaoCode IACO identifier for an airport.
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $icaoCode;
}
