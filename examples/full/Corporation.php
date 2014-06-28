<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Corporation
 * 
 * @link http://schema.org/Corporation
 * 
 * @ORM\Entity
 */
class Corporation extends Organization
{
    /**
     * Ticker Symbol
     * 
     * @var string $tickerSymbol The exchange traded instrument associated with a Corporation object. The tickerSymbol is expressed as an exchange and an instrument name separated by a space character. For the exchange component of the tickerSymbol attribute, we reccommend using the controlled vocaulary of Market Identifier Codes (MIC) specified in ISO15022.
     * 
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $tickerSymbol;
}
