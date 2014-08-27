<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A shop that will buy, or lend money against the security of, personal possessions.
 * 
 * @see http://schema.org/PawnShop Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class PawnShop extends Store
{
}
