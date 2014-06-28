<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Rent Action
 * 
 * @link http://schema.org/RentAction
 * 
 * @ORM\Entity
 */
class RentAction extends TradeAction
{
    /**
     * Landlord
     * 
     * @var Organization $landlord A sub property of participant. The owner of the real estate property. Sub property of destination or participant?
     * 
     * @ORM\ManyToOne(targetEntity="Organization")
     */
    private $landlord;
    /**
     * Real Estate Agent
     * 
     * @var RealEstateAgent $realEstateAgent A sub property of participant. The real estate agent involved in the action.
     * 
     * @ORM\ManyToOne(targetEntity="RealEstateAgent")
     */
    private $realEstateAgent;
}
