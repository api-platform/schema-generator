<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Bank or Credit Union
 * 
 * @link http://schema.org/BankOrCreditUnion
 * 
 * @ORM\Entity
 */
class BankOrCreditUnion extends FinancialService
{
}
