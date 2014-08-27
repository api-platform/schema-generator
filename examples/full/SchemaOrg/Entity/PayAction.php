<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * An agent pays a price to a participant.
 * 
 * @see http://schema.org/PayAction Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class PayAction extends TradeAction
{
    /**
     * @type MedicalDevicePurpose $purpose A goal towards an action is taken. Can be concrete or abstract.
     * @ORM\ManyToOne(targetEntity="MedicalDevicePurpose")
     */
    private $purpose;
    /**
     * @type Audience $recipient A sub property of participant. The participant who is at the receiving end of the action.
     * @ORM\ManyToOne(targetEntity="Audience")
     */
    private $recipient;
}
