<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * The act of giving money in return for temporary use, but not ownership, of an object such as a vehicle or property. For example, an agent rents a property from a landlord in exchange for a periodic payment.
 * 
 * @see http://schema.org/RentAction Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class RentAction extends TradeAction
{
    /**
     * @type Organization $landlord A sub property of participant. The owner of the real estate property.
     * @ORM\ManyToOne(targetEntity="Organization")
     */
    private $landlord;
    /**
     * @type RealEstateAgent $realEstateAgent A sub property of participant. The real estate agent involved in the action.
     * @ORM\ManyToOne(targetEntity="RealEstateAgent")
     */
    private $realEstateAgent;
}
