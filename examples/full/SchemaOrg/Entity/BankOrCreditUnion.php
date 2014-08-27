<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Bank or credit union.
 * 
 * @see http://schema.org/BankOrCreditUnion Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class BankOrCreditUnion extends FinancialService
{
}
