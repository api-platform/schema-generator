<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Financial services business.
 * 
 * @see http://schema.org/FinancialService Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class FinancialService extends LocalBusiness
{
}
