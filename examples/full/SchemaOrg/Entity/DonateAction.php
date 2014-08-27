<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * The act of providing goods, services, or money without compensation, often for philanthropic reasons.
 * 
 * @see http://schema.org/DonateAction Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class DonateAction extends TradeAction
{
    /**
     * @type Audience $recipient A sub property of participant. The participant who is at the receiving end of the action.
     * @ORM\ManyToOne(targetEntity="Audience")
     */
    private $recipient;
}
