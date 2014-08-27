<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * An agent orders an object/product/service to be delivered/sent.
 * 
 * @see http://schema.org/OrderAction Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class OrderAction extends TradeAction
{
}
