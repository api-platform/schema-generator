<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Accountancy business.
 * 
 * @see http://schema.org/AccountingService Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class AccountingService extends FinancialService
{
}
