<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Financial Service
 * 
 * @link http://schema.org/FinancialService
 * 
 * @ORM\MappedSuperclass
 */
class FinancialService extends LocalBusiness
{
}
