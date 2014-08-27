<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * An agent quotes/estimates/appraises an object/product/service with a price at a location/store.
 * 
 * @see http://schema.org/QuoteAction Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class QuoteAction extends TradeAction
{
}
