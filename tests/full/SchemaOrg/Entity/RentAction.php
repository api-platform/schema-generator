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
     */
    private $landlord;
    /**
     */
    private $realEstateAgent;
}
