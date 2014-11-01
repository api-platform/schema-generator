<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * The act of giving money voluntarily to a beneficiary in recognition of services rendered.
 * 
 * @see http://schema.org/TipAction Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class TipAction extends TradeAction
{
    /**
     */
    private $recipient;
}
