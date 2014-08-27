<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * An Insurance agency.
 * 
 * @see http://schema.org/InsuranceAgency Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class InsuranceAgency extends FinancialService
{
}
