<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * ATM/cash machine.
 * 
 * @see http://schema.org/AutomatedTeller Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class AutomatedTeller extends FinancialService
{
}
